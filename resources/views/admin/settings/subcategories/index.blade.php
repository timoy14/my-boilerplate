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
                                    <th>{{ __('lang.icon') }}</th>
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
                                            data-target="#ViewModal-{{$subcategory->id}}">
                                            {{ __('lang.view') }}
                                        </button>
                                    </td>
                                    <td width="5%">
                                        <img src="{{ asset('storage/'.$subcategory->icon)}}" style="width: 100%"
                                            id="proof-icon" class="logo-icon img-centered">
                                    </td>
                                    <td>
                                        {{ (session()->get('locale') === 'ar') ? $subcategory->category->ar: $subcategory->category->en}}
                                    </td>
                                    <td>{{ $subcategory->ar }}</td>
                                    <td>{{ $subcategory->en }}</td>
                                    <td>{{ $subcategory->id }}</td>
                                </tr>

                                <div class="modal fade" id="ViewModal-{{$subcategory->id}}">
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
                                                                    {{ __('lang.icons') }}
                                                                </label>

                                                                <img src="{{ asset('storage/'.$subcategory->icon)}}"
                                                                    style="width: 100%" id="proof-icon"
                                                                    class="logo-icon img-centered">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">
                                                                            {{ __('lang.arabic') }}
                                                                        </label>
                                                                        <textarea class="form-control" name="ar"
                                                                            rows="2" id="ar"
                                                                            disabled> {{ $subcategory->ar }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">
                                                                            {{ __('lang.english') }}
                                                                        </label>
                                                                        <textarea class="form-control" name="en"
                                                                            rows="2" id="en"
                                                                            disabled> {{ $subcategory->en }}</textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">
                                                                            {{ __('lang.categories') }}
                                                                        </label>
                                                                        <textarea class="form-control" name="category"
                                                                            rows="2" id="category"
                                                                            disabled>  {{ (session()->get('locale') === 'ar') ? $subcategory->category->ar: $subcategory->category->en}}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">
                                                                            {{ __('lang.description') }}
                                                                        </label>
                                                                        <textarea class="form-control"
                                                                            name="description" rows="2" id="description"
                                                                            disabled> {{ $subcategory->description }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-inverse-primary"
                                                    data-dismiss="modal">
                                                    <i class="fa fa-times"></i>&nbsp{{ __('lang.close') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

@endsection
@section('script')
<script type="text/javascript">
    $( document ).ready(function() {

     $('#ViewModal').on('show.bs.modal',function (e){
    //    var en = $(e.relatedTarget).data('en');
    //    var ar = $(e.relatedTarget).data('ar');
    //    var icon = $(e.relatedTarget).data('icon');
    //    var description = $(e.relatedTarget).data('description');
    //    var display = $(e.relatedTarget).data('display');
    //    var category = $(e.relatedTarget).data('category');

    //    var x = location.origin;
    //   var proof = x +'/storage/'+icon;
    //   $('#proof-icon').attr('src', proof);
    //    $(e.currentTarget).find('textarea[id="en"]').html(en);
    //    $(e.currentTarget).find('textarea[id="ar"]').html(ar);
    //    $(e.currentTarget).find('textarea[id="description"]').html(description);
    //    $(e.currentTarget).find('textarea[id="category"]').html(category);
    //    if(display==1){
    //      $(e.currentTarget).find('textarea[id="display"]').html('display');
    //    } else{
    //      $(e.currentTarget).find('textarea[id="display"]').html('hide');
    //    }
    //  });
   });
</script>
@endsection
