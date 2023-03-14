@extends('layouts.app')

@section('content')
<div class="container">
<form method="post" id="payment-form" action="{{route('user.checkout', ['promotion'=>$promotion, 'apartment'=>$apartment])}}">
    @csrf
                <section>
                    <label for="amount">
                        <span class="input-label d-none">Amount</span>
                        <div class="input-wrapper amount-wrapper">
                            <input class="d-none" id="amount" name="amount" type="tel" min="1" placeholder="Amount" value="{{$promotion->price}}">
                        </div>
                    </label>

                    <div class="bt-drop-in-wrapper">
                        <div id="bt-dropin"></div>
                    </div>
                </section>

                <input id="nonce" name="payment_method_nonce" type="hidden" />
                <button class="button" type="submit"><span>Test Transaction</span></button>
            </form>
</div>
@endsection


<script src="https://js.braintreegateway.com/web/dropin/1.36.0/js/dropin.min.js"></script>
    <script>
        var form = document.querySelector('#payment-form');
        var client_token = "{{$token}}";

        braintree.dropin.create({
          authorization: client_token,
          selector: '#bt-dropin',
          
        }, function (createErr, instance) {
          if (createErr) {
            console.log('Create Error', createErr);
            return;
          }
          form.addEventListener('submit', function (event) {
            event.preventDefault();

            instance.requestPaymentMethod(function (err, payload) {
              if (err) {
                console.log('Request Payment Method Error', err);
                return;
              }

              // Add the nonce to the form and submit
              document.querySelector('#nonce').value = payload.nonce;
              form.submit();
            });
          });
        });
    </script>