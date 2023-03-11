<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ApartmentController;
use App\Http\Controllers\User\MessageController;
use App\Http\Controllers\User\PromotionController;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\PaymentRequest;

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
            return view('dashboard');
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

        Route::get('/braintree', function () {

            $gateway = new Braintree\Gateway([
                'environment' => config('services.braintree.environment'),
                'merchantId' => config('services.braintree.merchantId'),
                'publicKey' => config('services.braintree.publicKey'),
                'privateKey' => config('services.braintree.privateKey')
            ]);
        
            $token = $gateway->ClientToken()->generate();
            return view('user.apartments.braintree',[
                'token'=>$token
            ]);
            
        })->name("braintree");

        Route::post('/checkout', function (PaymentRequest $request) {
            
            $gateway = new Braintree\Gateway([
                'environment' => config('services.braintree.environment'),
                'merchantId' => config('services.braintree.merchantId'),
                'publicKey' => config('services.braintree.publicKey'),
                'privateKey' => config('services.braintree.privateKey')
            ]);
            

            $amount = $request->amount;
            $nonce = $request->payment_method_nonce;
            
            
                    
            $result = $gateway->transaction()->sale([
                'amount' => $amount,
                'paymentMethodNonce' => "fake-valid-nonce",
                'options' => [
                    'submitForSettlement' => true
                ]
            ]);

            
            if ($result->success) {
                $transaction = $result->transaction;
                return redirect()->route("user.dashboard")->with('message', 'pagamento effettuato');
            } else {
                $errorString = "";
            
                foreach($result->errors->deepAll() as $error) {
                    $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
                }
            
                return back()->withErrors('La transazione è fallita.');
            }
        });
        
    });

require __DIR__ . '/auth.php';
