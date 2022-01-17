@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin-users.customers.store') }}"
                 method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.customers') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 ">
                                <!-- <div class="form-group">
                                    <div class="offset-md-3 col-md-4 ">
                                        
                                            <div>
                                                <input style="margin-top: 20%;" type="file" class="form-control" name="file" accept="image/*">
                                            </div>
                                    </div>
                                </div>
                                -->
                            </div>
                            <div class="col-md-6 ">
                                <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.name') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="name" 
                                         class="form-control"
                                            autocomplete="off">
                                        @if ($errors->has('name'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.email') }}
                                    </label>
                                    <input type="email" name="email" 
                                     class="form-control"
                                        autocomplete="off">
                                    @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.phone') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="phone" 
                                     maxlength="10"
                                        class="form-control" autocomplete="off">
                                    @if ($errors->has('phone'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.genders') }}
                                    </label>
                                    <select name="gender" class="form-control" dir="rtl">
                                        @foreach ($genders as $gender)
                                        <option value="{{$gender->id}}">
                                            {{ (session()->get('locale') === 'ar') ? $gender->ar: $gender->en }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('gender'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                              
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.cities') }}
                                    </label>
                                    <select name="city" class="form-control" dir="rtl">
                                        @foreach ($cities as $city)
                                        <option 
                                            value="{{$city->id}}">
                                            {{ (session()->get('locale') === 'ar') ? $city->ar: $city->en }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('city'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin-users.customers.index') }}"
                         class="btn btn-inverse-primary">
                            {{ __('lang.back') }}
                        </a>
                        <button type="submit" class="btn btn-primary float-right">{{ __('lang.submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('partials._edit_map')
@endsection
@section('script')
<script type="text/javascript">
    $(document).on("click", ".browse", function() {
       var file = $(this).parents().find(".file");
       file.trigger("click");
    });

    $('input[type="file"]').change(function(e) {

        var fileName = e.target.files[0].name;
        $("#file").val(fileName);
        var reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById("preview").src = e.target.result;
        };

        reader.readAsDataURL(this.files[0]);
   });
</script>
<script type="text/javascript">
    $(document).on("click", ".browse", function() {
       var file = $(this).parents().find(".file");
       file.trigger("click");
    });

    $('input[type="file"]').change(function(e) {

        var fileName = e.target.files[0].name;
        $("#file").val(fileName);
        var reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById("preview").src = e.target.result;
        };

        reader.readAsDataURL(this.files[0]);
   });

</script>

@endsection
