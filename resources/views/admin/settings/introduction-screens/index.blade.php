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
                            <a href="{{ route('settings.introduction-screens.create')}}"
                                class="btn btn-success btn-round btn-md mt-2">{{ __('lang.introduction') }}
                                {{ __('lang.screens') }} <i class="fa fa-plus"></i></a>
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
                                    <th>{{ __('lang.show') }}</th>
                                    <th>{{ __('lang.role') }}</th>
                                    <th>{{ __('lang.arabic') }}</th>
                                    <th>{{ __('lang.english') }}</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($introductionScreens as $introductionScreen)
                                <tr>
                                    <td width="5%">
                                        <form
                                            action="{{ route('settings.introduction-screens.destroy', $introductionScreen->id) }}"
                                            class="wbd-form" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-round btn-sm">
                                                {{ __('lang.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                    <td width="5%">
                                        <a href="{{ route('settings.introduction-screens.edit' , $introductionScreen->id )}}"
                                            class="btn btn-warning btn-round btn-sm">
                                            {{ __('lang.update') }}
                                        </a>
                                    </td>

                                    <td width="5%">
                                        <button class="btn btn-info btn-round btn-sm" data-toggle="modal"
                                            data-target="#ViewModal" data-en="{{ $introductionScreen->en }}"
                                            data-ar="{{ $introductionScreen->ar }}"
                                            data-display="{{ $introductionScreen->display}}"
                                            data-image="{{ $introductionScreen->image}}"
                                            data-role="{{ (session()->get('locale') === 'ar') ? $introductionScreen->role->ar: $introductionScreen->role->en}}">
                                            {{ __('lang.view') }}
                                        </button>
                                    </td>
                                    <td width="5%">
                                        @if ($introductionScreen->display == 1 )
                                        <a href="{{ route('settings.introduction-screens.show' , $introductionScreen->id )}}"
                                            class="btn btn-success btn-round btn-sm">

                                            {{ __('lang.display') }}

                                        </a>
                                        @endif
                                        @if ($introductionScreen->display == 0 )
                                        <a href="{{ route('settings.introduction-screens.show' , $introductionScreen->id )}}"
                                            class="btn btn btn-danger btn-round btn-sm">

                                            {{ __('lang.hide') }}

                                        </a>

                                        @endif

                                    </td>
                                    <td>
                                        {{ (session()->get('locale') === 'ar') ? $introductionScreen->role->ar: $introductionScreen->role->en}}
                                    </td>
                                    <td>{{ $introductionScreen->ar }}</td>
                                    <td>{{ $introductionScreen->en }}</td>
                                    <td>{{ $introductionScreen->id }}</td>
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
                                            {{ __('lang.arabic') }}
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
                                            {{ __('lang.role') }}
                                        </label>
                                        <textarea class="form-control" name="role" rows="2" id="role"
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

       var display = $(e.relatedTarget).data('display');
       var role = $(e.relatedTarget).data('role');

       var x = location.origin;
  var proof = x +'/storage/'+image;
  $('#proof-image').attr('src', proof);
       $(e.currentTarget).find('textarea[id="en"]').html(en);
       $(e.currentTarget).find('textarea[id="ar"]').html(ar);

       $(e.currentTarget).find('textarea[id="role"]').html(role);
       if(display==1){
         $(e.currentTarget).find('textarea[id="display"]').html('display');
       } else{
         $(e.currentTarget).find('textarea[id="display"]').html('hide');
       }



     });

   });
</script>
@endsection
