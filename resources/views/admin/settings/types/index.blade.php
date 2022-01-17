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
                        <div class="col-md-4 mt-1 pull-right">
                            <label>{{ __('lang.filter') }} {{ __('lang.categories') }}</label>
                            <select name="category_id" id="filter_category" class="form-control"
                                value="{{ old('country_id') }}">
                                <option selected disabled>
                                    {{ (session()->get('locale') === 'ar') ? $selected->ar: $selected->en}}
                                </option>
                                <option>
                                <option value="{{route('settings.types.index')}}" dir="rtl">

                                    {{ __('lang.all') }}

                                </option>
                                </option>
                                @foreach ($categories as $category)

                                <option value="{{route('settings.types.show',$category->id)}}" dir="rtl">

                                    {{ (session()->get('locale') === 'ar') ? $category->ar: $category->en}}

                                </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-8 mt-1 pull-right">
                            <button class="btn btn-success btn-round btn-md mt-2" data-toggle="modal"
                                data-target="#AddModal">
                                {{ __('lang.types') }} <i class="fa fa-plus"></i>
                            </button>
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
                                    <th>{{ __('lang.categories') }}</th>
                                    <th>{{ __('lang.arabic') }}</th>
                                    <th>{{ __('lang.english') }}</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($types as $type)
                                <tr>
                                    <td width="5%">
                                        <form action="{{ route('settings.types.destroy', $type->id) }}" class="wbd-form"
                                            method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-round btn-sm">
                                                {{ __('lang.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                    <td width="5%">
                                        <button class="btn btn-warning btn-round btn-sm" data-toggle="modal"
                                            data-target="#EditModal" data-id="{{ $type->id }}"
                                            data-category="{{ $type->category_id }}" data-en="{{ $type->en }}"
                                            data-ar="{{ $type->ar }}">
                                            {{ __('lang.update') }}
                                        </button>
                                    </td>
                                    <td>{{ (session()->get('locale') === 'ar') ? @$type->category->ar: @$type->category->en }}
                                    </td>
                                    <td>{{ $type->ar }}</td>
                                    <td>{{ $type->en }}</td>
                                    <td>{{ $type->id }}</td>
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

<div class="modal fade" id="AddModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span>&nbsp</span>
                <h5 class="modal-title float-right">{{ __('lang.types') }}</h5>
            </div>

            <form action="{{ route('settings.types.store') }}" method="POST">

                {{csrf_field()}}

                <div class="modal-body">

                    <div class="form-group">
                        <label>{{ __('lang.categories') }}</label>
                        <select class="form-control" name="category" dir="rtl">
                            @foreach($categories as $category);
                            <option value="{{ $category->id }}">{{ $category->ar }} / {{ $category->en }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>{{ __('lang.english') }}</label>
                        <input type="text" class="form-control" name="en" value="" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('lang.arabic') }}</label>
                        <input type="text" class="form-control" name="ar" value="" autocomplete="off" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">
                        <i class="fa fa-times"></i>&nbsp{{ __('lang.close') }}</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check-square-o"></i>&nbsp{{ __('lang.submit') }}</button>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="EditModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span>&nbsp</span>
                <h5 class="modal-title float-right">{{ __('lang.types') }}</h5>
            </div>
            <form action="{{ route('settings.types.update', 'update' ) }}" method="POST">
                {{csrf_field()}}
                {{ method_field('PUT') }}

                <input type="hidden" id="id" name="id" value="" class="form-control">

                <div class="modal-body">

                    <div class="form-group">
                        <label>{{ __('lang.categories') }}</label>
                        <select class="form-control" id="category" name="category" dir="rtl">
                            @foreach($categories as $category);
                            <option value="{{ $category->id }}">{{ $category->ar }} / {{ $category->en }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>{{ __('lang.english') }}</label>
                        <input type="text" class="form-control" name="en" id="en" value="" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('lang.arabic') }}</label>
                        <input type="text" class="form-control" name="ar" id="ar" value="" autocomplete="off" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">
                        <i class="fa fa-times"></i>&nbsp{{ __('lang.close') }}</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check-square-o"></i>&nbsp{{ __('lang.submit') }}</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $( document ).ready(function() {

    $('#EditModal').on('show.bs.modal',function (e){

      var id = $(e.relatedTarget).data('id');
      var category = $(e.relatedTarget).data('category');
      var en = $(e.relatedTarget).data('en');
      var ar = $(e.relatedTarget).data('ar');

      console.log(id);

      $(e.currentTarget).find('input[id="id"]').val(id);
      $(e.currentTarget).find('input[id="en"]').val(en);
      $(e.currentTarget).find('input[id="ar"]').val(ar);
      $(e.currentTarget).find('select[id="category"]').val(category);
    });

  });
  $('#filter_category').change( function() {
    var link = $(this).val();
    console.log(link);

    location.href = link;
  });
</script>
@endsection
