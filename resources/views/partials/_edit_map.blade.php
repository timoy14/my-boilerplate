
<div class="modal fade" id="map-client-modal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
    <div class="modal-content ">
        <div class="modal-header bg-dark">
        <h5 class="modal-title text-white">{{ __('lang.map') }}</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div id="address-map-container" style="width:100%;height:400px; ">
                    <div style="width: 100%; height: 100%" id="map-client"></div>
                </div>
            </div>
        </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-inverse-dark" data-dismiss="modal"><i class="fa fa-check-square-o"></i> {{ __('lang.confirm') }}</button>
        <!-- <button type="button" class="btn btn-dark"><i class="fa fa-check-square-o"></i> {{ __('lang.save') }} </button> -->
        </div>
    </div>
    </div>
</div>

@section("script")
<script>
     function initMapClient() {
        const myLatlng = { lat: 24.7136, lng: 46.6753 };
        const map = new google.maps.Map(document.getElementById("map-client"), {
            zoom: 5,
            center: myLatlng,
        });
        // Create the initial InfoWindow.
        let infoWindow = new google.maps.InfoWindow({
            content: "{{__('lang.select_location')}}",
            position: myLatlng,
        });
        
        infoWindow.open(map);
        // Configure the click listener.
        map.addListener("click", (mapsMouseEvent) => {
            // Close the current InfoWindow.
            infoWindow.close();
            // Create a new InfoWindow.
            infoWindow = new google.maps.InfoWindow({
                position: mapsMouseEvent.latLng,
            });
            infoWindow.setContent(
                JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
                );
                infoWindow.open(map);
                // console.log('LAT:'+mapsMouseEvent.latLng.lat+' LNG:'+mapsMouseEvent.latLng.lng);
                const mapObj = mapsMouseEvent.latLng.toJSON();
                console.log(mapObj);

            var latlng = new google.maps.LatLng(mapObj.lat, mapObj.lng);
            // This is making the Geocode request
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng },  (results, status) =>{
                if (status !== google.maps.GeocoderStatus.OK) {
                    alert(status);
                }
                // This is checking to see if the Geoeode Status is OK before proceeding
                if (status == google.maps.GeocoderStatus.OK) {
                    var address = (results[0].formatted_address);
                    $('#address').val(address);
                }
            });
            
            $('#latitude').val(mapObj.lat);
            $('#longitude').val(mapObj.lng);
            initMapClientDisplay();
        });
    }
    function initMapClientDisplay() {
        console.log("TEST");
        let latitude = parseInt($("#latitude").val());
        let longitude = parseInt($("#longitude").val());
        let name = $("#name").val();

        const myLatlng = { lat: latitude, lng: longitude };
        const map = new google.maps.Map(document.getElementById("map-client-display"), {
            zoom: 5,
            center: myLatlng,
        });

        marker = new google.maps.Marker({
            position: myLatlng,
            label: name,
            map,
        });

        // To add the marker to the map, call setMap();
        marker.setMap(map);
    }
initMapClientDisplay();
initMapClient();
</script>
@endsection