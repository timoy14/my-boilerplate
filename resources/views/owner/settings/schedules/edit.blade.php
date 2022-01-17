@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('settings.subcategories.update' , $subcategory->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.subcategories') }}
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">

                                                <img src="{{ asset('storage/'.$subcategory->image)}}" id="preview"
                                                    class="logo-icon img-centered">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.images') }}
                                                </label>
                                                <input type="file" class="form-control" name="image" accept="image/*">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.arabic') }}
                                                </label>
                                                <textarea class="form-control" name="ar" rows="2"
                                                    id="ar">{{ $subcategory->ar }}</textarea>
                                                @if ($errors->has('ar'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('ar') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.english') }}
                                                </label>
                                                <textarea class="form-control" name="en" rows="2"
                                                    id="en">{{ $subcategory->en }}</textarea>
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
                                                    {{ __('lang.categories') }}
                                                </label>
                                                <select name="category_id" class="form-control" dir="rtl">
                                                    @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ ($subcategory->category_id === $category->id) ? 'selected' : '' }}>
                                                        {{ (session()->get('locale') === 'ar') ? $category->ar: $category->en }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('category_id'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('category_id') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.description') }}
                                                </label>
                                                <textarea class="form-control" name="description" rows="2"
                                                    id="description">{{ $subcategory->description }}</textarea>
                                                @if ($errors->has('description'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('settings.subcategories.index') }}" class="btn btn-inverse-primary ">
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
    $(document).ready(function(){
  $("#hide").click(function(){
    $("p").hide();
  });
  $("#show").click(function(){
    $("p").show();
  });
});
</script>
@endsection
