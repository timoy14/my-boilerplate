@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('subscriptions.subscriptions.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.subscriptions') }}
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.name') }}
                                    </label>
                                    <input type="text" name="name_ar" value="{{ old('name_ar') }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('name_ar'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('name_ar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.name') }}
                                    </label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.descriptions') }} {{ __('lang.separate_with_new_line') }}
                                    </label>


                                    <textarea name="descriptions[]" id="descriptions" onfocusout="descriptionsout()"
                                        class="form-control multiple" multiple="multiple" class="form-control"
                                        rows="7"></textarea>
                                    <input type="hidden" name="description" id="description">
                                    @if ($errors->has('description'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.multiple_branch') }}
                                    </label>
                                    <input class="checkbox-input" name="multiple_branch" id="multiple_branch"
                                        type="checkbox" data-toggle="toggle" value="1">
                                    @if ($errors->has('multiple_branch'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('multiple_branch') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.branch_count') }}
                                    </label>
                                    <input type="number" name="branch_count" id="branch_count" value="0"
                                        class="form-control" autocomplete="off" step="any" disabled>
                                    @if ($errors->has('branch_count'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('branch_count') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.advertisement') }}
                                    </label>
                                    <input class="checkbox-input" name="advertisement" id="advertisement"
                                        type="checkbox" data-toggle="toggle" value="1">
                                    @if ($errors->has('advertisement'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('advertisement') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.advertisement_limit') }}
                                    </label>
                                    <input type="number" name="advertisement_limit" id="advertisement_limit" value="0"
                                        class="form-control" step="any" disabled>
                                    @if ($errors->has('advertisement_limit'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('advertisement_limit') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.offer') }}
                                    </label>
                                    <input class="checkbox-input" name="offer" id="offer" type="checkbox"
                                        data-toggle="toggle" value="1">
                                    @if ($errors->has('offer'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('offer') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.offer_limit') }}
                                    </label>
                                    <input type="number" name="offer_limit" id="offer_limit" value="0"
                                        class="form-control" step="any" disabled>
                                    @if ($errors->has('offer_limit'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('offer_limit') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.employee') }}
                                    </label>
                                    <input class="checkbox-input" name="employee" id="employee" type="checkbox"
                                        data-toggle="toggle" value="1">
                                    @if ($errors->has('employee'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('employee') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.branch_employee_limit') }}
                                    </label>
                                    <input type="number" name="branch_employee_limit" id="branch_employee_limit"
                                        value="0" class="form-control" step="any" disabled>
                                    @if ($errors->has('branch_employee_limit'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('branch_employee_limit') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.limit_services') }}
                                    </label>
                                    <input type="number" name="limit_services" id="limit_services" value="0"
                                        class="form-control" step="any">
                                    @if ($errors->has('limit_services'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('limit_services') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.display') }}
                                    </label>
                                    <input class="checkbox-input" name="display" id="display" type="checkbox"
                                        data-toggle="toggle" value="1">
                                    @if ($errors->has('display'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('display') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.duration') }} ( {{ __('lang.months') }})
                                    </label>
                                    <input type="number" name="duration" value="{{ old('duration') }}"
                                        class="form-control">
                                    @if ($errors->has('duration'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('duration') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.price') }}
                                    </label>
                                    <input type="number" name="price" value="{{ old('price') }}" class="form-control"
                                        step="any">
                                    @if ($errors->has('price'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('subscriptions.subscriptions.index') }}" class="btn btn-inverse-primary ">
                            {{ __('lang.back') }}
                        </a>
                        <button type="submit" class="btn btn-primary float-right">{{ __('lang.submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $( document ).ready(function() {

    function checkUnli(){
        var unli = $( "#unli" ).val();
        if (unli != '0') {
            $("#limit").val(-1);
            $("#limit").prop('disabled', true);
        }else{
            $("#limit").val(0);
            $("#limit").prop('disabled', false);
        }
    }


    $( "#unli" ).change(function() {
        checkUnli()
    });

    $( "#advertisement" ).change(function() {
        if ($('#advertisement').is(':checked')) {
            $('#advertisement_limit').prop('disabled', false);
        } else {
            $('#advertisement_limit').prop('disabled', true);
        }
    });

    $( "#offer" ).change(function() {
        if ($('#offer').is(':checked')) {
            $('#offer_limit').prop('disabled', false);
        } else {
            $('#offer_limit').prop('disabled', true);
        }
    });


    $( "#multiple_branch" ).change(function() {
        if ($('#multiple_branch').is(':checked')) {
            $('#branch_count').prop('disabled', false);
        } else {
            $('#branch_count').prop('disabled', true);
        }
    });
    $( "#employee" ).change(function() {
        if ($('#employee').is(':checked')) {
            $('#branch_employee_limit').prop('disabled', false);
        } else {
            $('#branch_employee_limit').prop('disabled', true);
        }
    });

    function descriptionsout(){
        txt = document.getElementById('descriptions').value;
        var array = txt.split(/\n/);
        $('#description').val(JSON.stringify( array ));
     document.getElementById("descriptions").innerHTML  = array.join("\n");

    }

        $('#descriptions').keypress(function(event){
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){

        txt = document.getElementById('descriptions').value;
        var array = txt.split(/\n/);

        $('#description').val(JSON.stringify( array ));


     document.getElementById("descriptions").innerHTML  = array.join("\n");

    console.log(txt);
     console.log(array)
	}
});


});

});
</script>
@endsection
