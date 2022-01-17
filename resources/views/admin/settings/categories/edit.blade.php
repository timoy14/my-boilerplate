@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('settings.categories.update' , $category->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.categories') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 ">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.images') }}
                                    </label>
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <img src="{{ ($category->image) ? asset('storage/'.$category->image): asset('images/defaults/intro-default.png') }}"
                                        id="preview" class="logo-icon img-centered">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.english') }}
                                    </label>
                                    <textarea class="form-control" name="en" rows="3"
                                        disabled>{{ $category->en}}</textarea>
                                    @if ($errors->has('en'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('en') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.arabic') }}
                                    </label>
                                    <textarea class="form-control" name="ar" rows="3">{{ $category->ar}}</textarea>
                                    @if ($errors->has('ar'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('ar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('settings.categories.index') }}" class="btn btn-inverse-primary ">
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
    $(document).on("click", ".browse", function() {
        var file = $(this).parents().find(".image");
        file.trigger("click");
     });
     
     $('input[type="file"]').change(function(e) {
 
         var fileName = e.target.files[0].name;
         $("#image").val(fileName);
         var reader = new FileReader();
 
         reader.onload = function(e) {
             document.getElementById("preview").src = e.target.result;
         };
 
         reader.readAsDataURL(this.files[0]);
    });
</script>
@endsection