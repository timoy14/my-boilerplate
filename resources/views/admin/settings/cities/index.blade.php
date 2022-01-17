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
                                {{ __('lang.cities') }} <i class="fa fa-plus"></i>
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
                                    <th>{{ __('lang.update') }} </th>
                                    <th>{{ __('lang.arabic') }} {{ __('lang.alternative') }}</th>
                                    <th>{{ __('lang.arabic') }} {{ __('lang.alternative') }}</th>
                                    <th>{{ __('lang.arabic') }} {{ __('lang.alternative') }}</th>
                                    <th>{{ __('lang.english') }} {{ __('lang.alternative') }}</th>
                                    <th>{{ __('lang.arabic') }}</th>
                                    <th>{{ __('lang.english') }}</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cities as $city)
                                <tr>
                                    <td width="5%">
                                        <form action="{{ route('settings.cities.destroy', $city->id) }}"
                                            class="wbd-form" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-round btn-sm">
                                                {{ __('lang.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                    <td width="5%">
                                        <button class="btn btn-warning btn-round btn-sm" data-toggle="modal"
                                            data-target="#EditModal" data-id="{{ $city->id }}" data-en="{{ $city->en }}"
                                            data-ar="{{ $city->ar }}" data-en_1="{{ $city->en_1 }}"
                                            data-ar_1="{{ $city->ar_1 }}" data-ar_2="{{ $city->ar_2 }}"
                                            data-ar_3="{{ $city->ar_3 }}">
                                            {{ __('lang.update') }}
                                        </button>
                                    </td>
                                    <td>{{ $city->ar_3 }}</td>
                                    <td>{{ $city->ar_2 }}</td>
                                    <td>{{ $city->ar_1 }}</td>
                                    <td>{{ $city->en_1 }}</td>
                                    <td>{{ $city->ar }}</td>
                                    <td>{{ $city->en }}</td>
                                    <td>{{ $city->id }}</td>
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
                <h5 class="modal-title float-right">{{ __('lang.cities') }}</h5>
            </div>

            <form action="{{ route('settings.cities.store') }}" method="POST">

                {{csrf_field()}}

                <div class="modal-body">

                    <div class="form-group">
                        <label>{{ __('lang.english') }}</label>
                        <input type="text" class="form-control" name="en" value="" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('lang.arabic') }}</label>
                        <input type="text" class="form-control" name="ar" value="" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('lang.english') }} {{ __('lang.alternative') }}</label>
                        <input type="text" class="form-control" name="en_1" value="" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('lang.arabic') }} {{ __('lang.alternative') }}</label>
                        <input type="text" class="form-control" name="ar_1" value="" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('lang.arabic') }} {{ __('lang.alternative') }}</label>
                        <input type="text" class="form-control" name="ar_2" value="" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('lang.arabic') }} {{ __('lang.alternative') }}</label>
                        <input type="text" class="form-control" name="ar_3" value="" autocomplete="off" required>
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
                <h5 class="modal-title float-right">{{ __('lang.cities') }}</h5>
            </div>
            <form action="{{ route('settings.cities.update', 'update' ) }}" method="POST">
                {{csrf_field()}}
                {{ method_field('PUT') }}

                <input type="hidden" id="id" name="id" value="" class="form-control">

                <div class="modal-body">

                    <div class="form-group">
                        <label>{{ __('lang.english') }}</label>
                        <input type="text" class="form-control" name="en" id="en" value="" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('lang.arabic') }}</label>
                        <input type="text" class="form-control" name="ar" id="ar" value="" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('lang.english') }} {{ __('lang.alternative') }}</label>
                        <input type="text" class="form-control" name="en_1" id="en_1" value="" autocomplete="off"
                            required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('lang.arabic') }} {{ __('lang.alternative') }}</label>
                        <input type="text" class="form-control" name="ar_1" id="ar_1" value="" autocomplete="off"
                            required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('lang.english') }} {{ __('lang.alternative') }}</label>
                        <input type="text" class="form-control" name="ar_2" id="ar_2" value="" autocomplete="off"
                            required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('lang.arabic') }} {{ __('lang.alternative') }}</label>
                        <input type="text" class="form-control" name="ar_3" id="ar_3" value="" autocomplete="off"
                            required>
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

      var en_1 = $(e.relatedTarget).data('en_1');
      var ar_1 = $(e.relatedTarget).data('ar_1');
      var ar_2 = $(e.relatedTarget).data('ar_2');
      var ar_3 = $(e.relatedTarget).data('ar_3');

      console.log(id);

      $(e.currentTarget).find('input[id="id"]').val(id);
      $(e.currentTarget).find('input[id="en"]').val(en);
      $(e.currentTarget).find('input[id="ar"]').val(ar);

      $(e.currentTarget).find('input[id="en_1"]').val(en_1);
      $(e.currentTarget).find('input[id="ar_1"]').val(ar_1);
      $(e.currentTarget).find('input[id="ar_2"]').val(ar_2);
      $(e.currentTarget).find('input[id="ar_3"]').val(ar_3);
    });

  });
</script>
@endsection
