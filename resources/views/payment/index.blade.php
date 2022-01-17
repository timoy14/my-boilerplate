<script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.4/bluebird.min.js"></script>
<script src="https://secure.gosell.io/js/sdk/tap.min.js"></script>

@extends('layouts.payment')
@section('content')
<form id="form-container" method="post" action="{{route('payment.charge')}}">
    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
    <input name="payment" type="hidden" value="1" />
    <h4 class="text-center">Payment</h4>
    <div class="row">
        <div class="card col-12">
            <div class="card-header">
            </div>
            <div class="card-body">
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card col-12">
            <!-- Tap element will be here -->
            <div id="element-container" style="margin-top:20px;"></div>
            <div id="error-handler" role="alert"></div>
            <div id="success" style=" display: none;;position: relative;float: left;">
                <span id="token"></span>
            </div>
            <!-- Tap pay button -->


        </div>
    </div>
    <div class="row">
        <button type="submit" class="btn btn-dark col-12">Pay</button>
    </div>
</form>


@endsection

@push('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.4/bluebird.min.js"></script>
<script src="https://secure.gosell.io/js/sdk/tap.min.js"></script>
<script>
    //pass your public key from tap's dashboard
var tap = Tapjsli('pk_test_HkYa4GdX7C9Ui58WSPF2smoz');

var elements = tap.elements({});

var style = {
  base: {
    color: '#535353',
    lineHeight: '18px',
    fontFamily: 'sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: 'rgba(0, 0, 0, 0.26)',
      fontSize:'15px'
    }
  },
  invalid: {
    color: 'red'
  }
};
// input labels/placeholders
var labels = {
    cardNumber:"Card Number",
    expirationDate:"MM/YY",
    cvv:"CVC",
    cardHolder:"Name on card"
  };
//payment options
var paymentOptions = {
  currencyCode:["SAR"],
  labels : labels,
  TextDirection:'rtl'
}
//create element, pass style and payment options
var card = elements.create('card', {style: style},paymentOptions);
//mount element
card.mount('#element-container');
//card change event listener
card.addEventListener('change', function(event) {
  if(event.loaded){
    //console.log("UI loaded :"+event.loaded);
    //console.log("current currency is :"+card.getCurrency())
  }
  var displayError = document.getElementById('error-handler');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission
var form = document.getElementById('form-container');
form.addEventListener('submit', function(event) {
  event.preventDefault();

  tap.createToken(card).then(function(result) {
    console.log(result);
    if (result.error) {
      // Inform the user if there was an error
      var errorElement = document.getElementById('error-handler');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server
      var errorElement = document.getElementById('success');
      errorElement.style.display = "block";
      var tokenElement = document.getElementById('token');
    //   tokenElement.textContent = result.id;
      tapTokenHandler(result)


    }
  });
});

function tapTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('form-container');

  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'tapToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}


card.addEventListener('change', function(event) {
  if(event.BIN){
    console.log(event.BIN)
  }
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});
</script>
@endpush