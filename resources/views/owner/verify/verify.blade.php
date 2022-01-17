@extends('layouts.auth')

@section('content')
<div class="otp-phone-verification container py-3">
    <div class="otp-phone-verification-card">
        <div class="card-body otp-phone-verification-card-body">
            <div class="text-center otp-login">

                {{__('lang.phone_verification')}}
            </div>
            <div class="card-title text-center mt-2">
                {{__('lang.phone_verification_message')}}
            </div>
            <div class="card-title text-center text-danger mt-2">

                {{Auth::user()->phone}}/ {{Auth::user()->name}}

            </div>
            <form class="mt-5 otp" method="POST" action="{{ route('owner-verify.verify.store') }}" id="form-otp">
                @csrf
                <div class="flex justify-center  otp-align-center" id="OTP-Input"></div>
                @if($errors->any())
                <div class=" text-center text-danger mt-2">
                    {{$errors->first()}}
                </div>
                @endif
                <input hidden id="otp-value" name="otp" value="">
                <div class="row justify-content-center mt-2">
                    {{__('lang.not_yet_recieved')}} &nbsp;
                    <a href="" class="text-primary"
                        onclick="event.preventDefault(); document.getElementById('resend-form').submit();">
                        </i>{{ __('lang.resend') }}
                    </a>
                    {{-- <a href="#" onclick="resendCode()" class="text-primary"> &nbsp;
                        {{__('lang.resend')}}</a> --}}

                </div>

                <div class="row justify-content-center mt-3">
                    <button type="submit" class="btn submit otp-blue-bg otp-white-c otp-submit">
                        {{__('lang.submit')}}</button>
                </div>

            </form>
            <form id="resend-form" action="{{ route('owner-verify.verify.resend') }}" method="POST"
                style="display: none;">
                @csrf
            </form>


        </div>
        <div class="row justify-content-center mt-4">
            <a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="icon-power mr-2"></i>{{ __('lang.logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')

@if (Auth::user()->id && $user->id)
<script type="text/javascript">
    var $otp_length = 4;
    var compiledOtp = '';
            var element = document.getElementById('OTP-Input');

            for (let i = 0; i < $otp_length; i++) {
                let inputField = document.createElement('input'); // Creates a new input element
                inputField.className =
                    "w-12 h-12 bg-gray-100 border-gray-100 outline-none focus:bg-gray-200  m-2 text-center rounded focus:border-blue-400 focus:shadow-outline";
                // Do individual OTP input styling here;
                inputField.style.cssText =
                    " width: 1em; font-size:50px "; // Input field text styling. This css hides the text caret
                inputField.id = 'otp-field' + i; // Don't remove
                inputField.maxLength = 1; // Sets individual field length to 1 char
                inputField.type ='tel';

                element.appendChild(inputField); // Adds the input field to the parent div (OTP-Input)
            }


            $("#otp-field0").focus();
            $("#otp-field0").click();


            var inputs = document.querySelectorAll('#OTP-Input > *[id]');

            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('keydown', function (event) {
                    if (event.key === "Backspace") {
                        if (inputs[i].value == '') {
                            if (i != 0) {
                                inputs[i - 1].focus();
                            }
                        } else {
                            inputs[i].value = '';
                        }
                    } else if (event.key === "ArrowLeft" && i !== 0) {
                        inputs[i - 1].focus();
                    } else if (event.key === "ArrowRight" && i !== inputs.length - 1) {
                        inputs[i + 1].focus();
                    } else if (event.key != "ArrowLeft" && event.key != "ArrowRight") {
                        inputs[i].setAttribute("type", "tel");
                        inputs[i].value = ''; // Bug Fix: allow user to change a random otp digit after pressing it
                    }
                });
                inputs[i].addEventListener('input', function () {
                    inputs[i].value = inputs[i].value
                        .toUpperCase(); // Converts to Upper case. Remove .toUpperCase() if conversion isnt required.

                        let value = inputs[i].value.toString();

                        compiledOtp = compiledOtp.replaceAt(i,value)
                        console.log(i);
                        if (i == 3) {
                            console.log(compiledOtp);
                            $("#otp-value").val(compiledOtp);
                            // document.getElementById('otp-value').value = compiledOtp;
                        }
                        if (i === inputs.length - 1 && inputs[i].value !== '') {

                        return true;
                    } else if (inputs[i].value !== '') {
                        inputs[i + 1].focus();
                    }
                });
            }
            String.prototype.replaceAt=function(index, char) {
                    var a = this.split("");
                    a[index] = char;
                    return a.join("");
                }

            // document.getElementById('otpSubmit').addEventListener("click", function () {
            //     const inputs = document.querySelectorAll('#OTP-Input > *[id]');
            //     let compiledOtp = '';
            //     for (let i = 0; i < inputs.length; i++) {
            //         compiledOtp += inputs[i].value;
            //     }
            //     console.log(compiledOtp);
            //     document.getElementById('otp').value = compiledOtp;
            //     return true;
            // });

            function resendCode()
            {
                $.ajax({
                    type: "POST",
                    url: "{{ route('owner-verify.verify.resend') }}",
                    data: {
                        '_token' : '{{ csrf_token() }}',

                    },
                    success: function(response)
                    {
                        console.log(response.resent);
                        if (response.resent === 'success') {


                            toastr.options = {
                                "positionClass": "toast-top-left"
                                        }
                                     toastr.success('{{__('lang.phone_verification_resend')}}');
                            return false;
                        }


                    }
                });
            }


            function invalidResponse()
            {
                // swal({
                //     title: "{{__('lang.warning')}}",
                //     text: "{{__('lang.phone_verification_incorrect')}}",
                //     icon: 'error',
                //     closeOnClickOutside: false,
                //     closeOnEsc: false,
                // });


            }

            function sessionExpired()
            {
                window.location.href = "{{ route('login') }}";
                // swal({
                //     title: "{{__('lang.your_session_expired')}}",
                //     text: "{{__('lang.your_session_restore')}}",
                //     icon: 'error',
                //     closeOnClickOutside: false,
                //     closeOnEsc: false,
                // }).then((result) => {
                //     if (result) {
                //         window.location.href = "{{ route('login') }}";
                //     }
                // });
            }






</script>

<script type="text/javascript">
    // swal({title: "{{__('lang.phone_verified')}}",
    // text: "{{__('lang.this_customer_already_verified_phone_number')}}",
    // icon: 'info',
    // closeOnClickOutside: false,
    // closeOnEsc: false,
    // }).then((result) => {
    // if (result) {
    //     window.location.href = "{!!route('home')!!}";
    // }
    // });
</script>

@endif

@endsection
