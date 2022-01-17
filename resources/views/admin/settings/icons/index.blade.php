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

                        <div class="col-md-12 mt-2 pull-right">
                            {{ __('lang.icon') }}
                        </div>

                    </div>
                    <form action="{{ route('settings.icons.store') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('lang.submit') }}</button>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="file" name="icon" value="" class="form-control"
                                        placeholder="{{ __('lang.icon') }}">


                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('lang.action') }}</th>
                                    <th>{{ __('lang.icon') }}
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($icons as $icon)
                                <tr>
                                    <td>

                                        <form action="{{ route('settings.icons.destroy', $icon->id) }}" class="wbd-form"
                                            method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-round btn-sm">
                                                {{ __('lang.delete') }}
                                            </button>
                                        </form>
                                    </td>

                                    <td>
                                        <div class="mt-1">

                                            <img src="{{asset('storage/'.$icon->icon)}}" width="100" height="100">
                                        </div>
                                    </td>

                                    <td>{{ $icon->id }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="table-pagination">
                        {!! $icons->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection

@section('script')
<script type="text/javascript">
    $( document ).ready(function() {

    $('#EditModal').on('show.bs.modal',function (e){

      var icon = $(e.relatedTarget).data('icon');

      console.log(icon);


    //   $(e.currentTarget).find('input[id="id"]').val(id);
    //   $(e.currentTarget).find('input[id="en"]').val(en);
    //   $(e.currentTarget).find('input[id="ar"]').val(ar);
    //   $(e.currentTarget).find('input[id="description"]').val(description);
    });

  });
</script>
@endsection
