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
                            <button class="btn btn-success btn-round btn-md mt-2" data-toggle="modal"
                                data-target="#AddModal">
                                {{ __('lang.areas') }} <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-1 pull-right">
                            <select name="city_id" id="filter_city" class="form-control" value="{{ old('city_id') }}">
                                <option selected disabled>

                                    {{ (session()->get('locale') === 'ar') ? $selected->ar: $selected->en}}
                                </option>
                                <option>
                                <option value="{{route('settings.areas.index')}}" dir="rtl">

                                    {{ (session()->get('locale') == 'ar') ? 'الكل': 'All' }}


                                </option>
                                </option>
                                @foreach ($cities as $city)

                                <option value="{{route('settings.areas.show',$city->id)}}" dir="rtl">

                                    {{ (session()->get('locale') == 'ar') ? $city->ar : $city->en }}

                                </option>
                                @endforeach
                            </select>

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
                                    <th>{{ __('lang.cities') }}</th>
                                    <th>{{ __('lang.arabic') }}</th>
                                    <th>{{ __('lang.english') }}</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($areas as $area)
                                <tr>
                                    <td width="5%">
                                        <form action="{{ route('settings.areas.destroy', $area->id) }}" class="wbd-form"
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
                                            data-target="#EditModal" data-id="{{ $area->id }}"
                                            data-city="{{ $area->city_id }}" data-en="{{ $area->en }}"
                                            data-ar="{{ $area->ar }}">
                                            {{ __('lang.update') }}
                                        </button>
                                    </td>
                                    <td>
                                        {{ (session()->get('locale') === 'ar') ? @$area->city->ar: @$area->city->en}}
                                    </td>

                                    <td>{{ $area->ar }}</td>
                                    <td>{{ $area->en }}</td>
                                    <td>{{ $area->id }}</td>
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
                <h5 class="modal-title float-right">{{ __('lang.areas') }}</h5>
            </div>

            <form action="{{ route('settings.areas.store') }}" method="POST">

                {{csrf_field()}}

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">{{ __('lang.cities') }} </label>
                        <select name="city_id" class="form-control" dir="rtl">
                            @foreach ($cities as $city)
                            <option value="{{ $city->id }}">
                                {{ (session()->get('locale') === 'ar') ? $city->ar: $city->en }}
                            </option>
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
                <h5 class="modal-title float-right">{{ __('lang.areas') }}</h5>
            </div>
            <form action="{{ route('settings.areas.update', 'update' ) }}" method="POST">
                {{csrf_field()}}
                {{ method_field('PUT') }}


                <input type="hidden" id="id" name="id" value="" class="form-control">

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">{{ __('lang.cities') }} </label>
                        <select id="city" name="city_id" class="form-control" dir="rtl">
                            @foreach ($cities as $city)
                            <option value="{{ $city->id }}">
                                {{ (session()->get('locale') === 'ar') ? $city->ar: $city->en }}
                            </option>
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
      var en = $(e.relatedTarget).data('en');
      var ar = $(e.relatedTarget).data('ar');
      var city = $(e.relatedTarget).data('city');

      console.log(id);

      $(e.currentTarget).find('input[id="id"]').val(id);
      $(e.currentTarget).find('input[id="en"]').val(en);
      $(e.currentTarget).find('input[id="ar"]').val(ar);
      $(e.currentTarget).find('select[id="city"]').val(city);
    });

  });
  $('#filter_city').change( function() {
    var link = $(this).val();
    // var link = "{{ route('settings.cities.show' ,191 ) }}";
    console.log(link);

    location.href = link;
  });
</script>
@endsection
