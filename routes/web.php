<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ApartmentController;
use App\Http\Controllers\User\MessageController;
use App\Http\Controllers\User\PromotionController;
use App\Http\Controllers\User\BraintreeController;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\PaymentRequest;
use App\Models\Apartment;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])
    ->name('user.')
    ->prefix('user')
    ->group(function () {
        Route::get('/dashboard', function () {
            $user = Auth::user();
            $apartments = Apartment::where('user_id', $user->id)->get();
            $messages = [];
            foreach ($apartments as $apartment) {
                if (count($apartment->messages)) {
                    foreach ($apartment->messages as $message) {
                        $messages[] = $message;
                    }
                }
            }
            return view('dashboard', compact("messages"));
        })->name("dashboard");
        Route::resource('/apartments', ApartmentController::class);
        Route::name('messages.')
            ->prefix('message')
            ->group(function () {
                Route::get('/index', [MessageController::class, 'index'])->name('index');
                Route::get('/{message}', [MessageController::class, 'show'])->name('show');
                Route::delete('/{message}', [MessageController::class, 'destroy'])->name('delete');
            });
        Route::name('promotions.')
            ->prefix('promotions')
            ->group(function () {
                Route::get('/index', [PromotionController::class, 'index'])->name('index');
            });


        Route::get('/braintree', function (Request $request) {




            $data = $request->all();

            if (!key_exists('promotion', $data) || !key_exists('apartment', $data)) {
                return view('errorPage', ['message' => 'Non sei autorizzato a vedere questo appartamento']);
            }



            $promotion = Promotion::findOrFail($data['promotion']);
            $apartment = Apartment::findOrFail($data['apartment']);



            $gateway = new Braintree\Gateway([
                'environment' => config('services.braintree.environment'),
                'merchantId' => config('services.braintree.merchantId'),
                'publicKey' => config('services.braintree.publicKey'),
                'privateKey' => config('services.braintree.privateKey')
            ]);



            $token = $gateway->ClientToken()->generate();
            return view('user.apartments.braintree', [
                'token' => $token,
                'apartment' => $apartment,
                'promotion' => $promotion
            ]);
        })->name("braintree");


        Route::post('/checkout', function (Request $request) {

            $gateway = new Braintree\Gateway([
                'environment' => config('services.braintree.environment'),
                'merchantId' => config('services.braintree.merchantId'),
                'publicKey' => config('services.braintree.publicKey'),
                'privateKey' => config('services.braintree.privateKey')
            ]);

            $data = $request->all();

            $promotion = Promotion::findOrFail($data['promotion']);
            $apartment = Apartment::findOrFail($data['apartment']);


            $amount = $request->amount;
            $nonce = $request->payment_method_nonce;

            $result = $gateway->transaction()->sale([
                'amount' => $amount,
                'paymentMethodNonce' => $nonce,
                'options' => [
                    'submitForSettlement' => true
                ]
            ]);
            if ($result->success) {
                DB::table('apartment_promotion')->insert([
                    'apartment_id' => $apartment->id,
                    'promotion_id' => $promotion->id,
                    'created_at' =>  Carbon::now(),
                    'expired_at' => Carbon::now()->addHours($promotion->duration)
                ]);
                return redirect()->route("user.dashboard")->with('message', 'pagamento effettuato');
            } else {
                $errorString = "";

                foreach ($result->errors->deepAll() as $error) {
                    $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
                }

                return redirect()->route("user.dashboard")->with('message', 'pagamento fallito.');
            }
        })->name("checkout");
    });

require __DIR__ . '/auth.php';
