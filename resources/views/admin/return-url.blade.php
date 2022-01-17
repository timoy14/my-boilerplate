@extends('layouts.payment')

@section('content')
<div>
    <pre>
    </pre>
</div>
@endsection

{{-- @push('head') --}}
<script>
    function redirectToApp() {
        var sites = {!! json_encode($arr_result) !!};
        console.log(sites);
        if (sites['card_brand'] !== 'APPLEPAY') {
            sites = JSON.stringify(sites);
            window.ReactNativeWebView.postMessage(sites, "*");
        } else {
            let link = sites['redirect_link'];
            window.location.replace(`${link}?card_brand=${sites['card_brand']}&status=${sites['status']}&message=${sites['message']}`);
        }

    }

    document.addEventListener('DOMContentLoaded', function() {
        redirectToApp();
    });
</script>
{{-- @endpush --}}
