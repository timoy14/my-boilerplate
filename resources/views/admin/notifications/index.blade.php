@extends('layouts.admin')
@section('css')
<style>
table#tablenotif thead {
    background-color: #305F73;
    color: #ffffff;
}
</style>
@endsection
@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                     <div class="row">
                        <div class="col-md-12">
                             <a data-toggle="modal" data-target="#ViewModalCreate"
                            class="btn btn-success btn-round btn-md mt-2">{{ __('lang.notifications') }} +</a>
                                
                        </div>
                    </div> 
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablenotif" class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('lang.created_at') }}</th>
                                    <th>{{ __('lang.status') }}</th>
                                    <th>{{ __('lang.message') }}</th>
                                    <th>{{ __('lang.title') }}</th>
                                    <th>{{ __('lang.slug') }}</th>
                                    <th>{{ __('lang.user_id') }}</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notification)
                                <tr>
                                    <td>{{ $notification->created_at }}</td>
                                    <td>{{ $notification->status }}</td>
                                    <td>{{ $notification->message }}</td>
                                    <td>{{ $notification->title }}</td>
                                    <td>{{ $notification->slug }}</td>
                                    <td>{{ $notification->user_id }}</td>
                                    <td>{{ $notification->id }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="table-pagination">
                        {{ $notifications->withQueryString()->onEachSide(1)->links('partials._links') }}
                        </div>
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
                <h5 class="modal-title float-right">{{ __('lang.notifications') }}</h5>
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
                                        <textarea class="form-control" name="ar" rows="3" id="ar" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.english') }}
                                        </label>
                                        <textarea class="form-control" name="en" rows="3" id="en" disabled></textarea>
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
<div class="modal fade" id="ViewModalCreate">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span>&nbsp</span>
                <h5 class="modal-title float-right">{{ __('lang.notification') }}</h5>
            </div>
            <form action="" method="POST">
            {{ csrf_field() }}
            {{ method_field('POST') }}
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-group">
                        <label>{{ __('lang.title') }}</label>
                        
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('lang.message') }}</label>
                        <textarea type="text" class="form-control" name="message" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>{{ __('lang.filter') }}</label>
                        <select class="form-control" name="role">
                            @foreach($roles as $role)
                                <option value="{{$role->id}}">{{ (session()->get('locale') === 'ar') ? $role->en: $role->ar}}</option>
                            @endforeach
                        </select>
                    </div> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">
                    <i class="fa fa-times"></i>{{ __('lang.close') }}
                </button>
                <button type="submit" class="btn btn-primary" >
                        {{ __('lang.submit') }}
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')

<script type="text/javascript">
    $('.datatable').DataTable({searching: false, paging: false, info: false,order: [ 0, 'desc' ]});
    $( document ).ready(function() {

     $('#ViewModal').on('show.bs.modal',function (e){
       var en = $(e.relatedTarget).data('en');
       var ar = $(e.relatedTarget).data('ar');
       var image = $(e.relatedTarget).data('image');
       var x = location.origin;
  var proof = x +'/storage/'+image;
  $('#proof-image').attr('src', proof);
       $(e.currentTarget).find('textarea[id="en"]').html(en);
       $(e.currentTarget).find('textarea[id="ar"]').html(ar);
      //  $(e.currentTarget).find('img[id="image"]').html(image);
     });

   });
</script>
@endsection
