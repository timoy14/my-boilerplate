<footer class="footer">
    <div class="container">
        <div class="text-center">
            <strong> {{ __('lang.copyright') }} ©  <?php echo date('Y'); ?> </strong>
        </div>
    </div>
</footer>

@section('script')
<script>
// $( "#back_func" ).click(function() {
// });

function goBack() {
   window.location.hash = window.location.lasthash[window.location.lasthash.length - 1];
   //blah blah blah
   window.location.lasthash.pop();
}
</script>
@endsection