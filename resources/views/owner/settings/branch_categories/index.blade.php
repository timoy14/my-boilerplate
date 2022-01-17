@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('settings.subcategories.create')}}"
                                class="btn btn-success btn-round btn-md mt-2">{{ __('lang.subcategories') }} <i
                                    class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('lang.delete') }}</th>
                                    <th>{{ __('lang.update') }}</th>
                                    <th>{{ __('lang.view') }}</th>

                                    <th>{{ __('lang.categories') }}</th>
                                    <th>{{ __('lang.arabic') }}</th>
                                    <th>{{ __('lang.english') }}</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subcategories as $subcategory)
                                <tr>
                                    <td width="5%">
                                        <form action="{{ route('settings.subcategories.destroy', $subcategory->id) }}"
                                            class="wbd-form" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-round btn-sm">
                                                {{ __('lang.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                    <td width="5%">
                                        <a href="{{ route('settings.subcategories.edit' , $subcategory->id )}}"
                                            class="btn btn-warning btn-round btn-sm">
                                            {{ __('lang.update') }}
                                        </a>
                                    </td>

                                    <td width="5%">
                                        <button class="btn btn-info btn-round btn-sm" data-toggle="modal"
                                            data-target="#ViewModal" data-en="{{ $subcategory->en }}"
                                            data-ar="{{ $subcategory->ar }}"
                                            data-description="{{ $subcategory->description}}"
                                            data-image="{{ $subcategory->image}}"
                                            data-category="{{ (session()->get('locale') === 'ar') ? $subcategory->category->ar: $subcategory->category->en}}">
                                            {{ __('lang.view') }}
                                        </button>
                                    </td>

                                    <td>
                                        {{ (session()->get('locale') === 'ar') ? $subcategory->category->ar: $subcategory->category->en}}
                                    </td>
                                    <td>{{ $subcategory->ar }}</td>
                                    <td>{{ $subcategory->en }}</td>
                                    <td>{{ $subcategory->id }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('home') }}" class="btn btn-inverse-primary float-right">
                        {{ __('lang.back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ViewModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span>&nbsp</span>
                <h5 class="modal-title float-right">{{ __('lang.categories') }}</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.images') }}
                                </label>
                                <img style="width: 100%" id="proof-image" src="">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.arabic') }}
                                        </label>
                                        <textarea class="form-control" name="ar" rows="2" id="ar" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.english') }}
                                        </label>
                                        <textarea class="form-control" name="en" rows="2" id="en" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.show') }}
                                        </label>
                                        <textarea class="form-control" name="display" rows="2" id="display"
                                            disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.categories') }}
                                        </label>
                                        <textarea class="form-control" name="category" rows="2" id="category"
                                            disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.description') }}
                                        </label>
                                        <textarea class="form-control" name="description" rows="2" id="description"
                                            disabled></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">
                    <i class="fa fa-times"></i>&nbsp{{ __('lang.close') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $( document ).ready(function() {

     $('#ViewModal').on('show.bs.modal',function (e){
       var en = $(e.relatedTarget).data('en');
       var ar = $(e.relatedTarget).data('ar');
       var image = $(e.relatedTarget).data('image');
       var description = $(e.relatedTarget).data('description');
       var display = $(e.relatedTarget).data('display');
       var category = $(e.relatedTarget).data('category');

       var x = location.origin;
      var proof = x +'/storage/'+image;
      $('#proof-image').attr('src', proof);
       $(e.currentTarget).find('textarea[id="en"]').html(en);
       $(e.currentTarget).find('textarea[id="ar"]').html(ar);
       $(e.currentTarget).find('textarea[id="description"]').html(description);
       $(e.currentTarget).find('textarea[id="category"]').html(category);
       if(display==1){
         $(e.currentTarget).find('textarea[id="display"]').html('display');
       } else{
         $(e.currentTarget).find('textarea[id="display"]').html('hide');
       }
     });
   });
</script>
@endsection
