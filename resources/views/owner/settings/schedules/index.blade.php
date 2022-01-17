@extends('layouts.admin')
@section('css')
<style type="text/css">
    .toggle {
        border: 1px solid #305f73;
    }
</style>
@endsection
@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-lg-12">
            @if ( $branches->count() >1)
            <div class="form-group">
                <select name="branch_id" id="branch_id" class="form-control" value="{{ old('branch_id') }}"
                    onchange="select()">
                    @foreach ($branches as $branch)

                    <option value="{{ $branch->id }}" {{ ($details== $branch->id) ? 'selected' : '' }} dir="rtl">
                        {{ $branch->name}}

                    </option>

                    @endforeach
                </select>
            </div>
            @endif
            @foreach ($branches as $branch)
            <div id="branch-data-{{$branch->id}}">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ __('lang.branches') }}:
                            {{ (session()->get('locale') === 'ar') ?  $branch->name_ar :  $branch->name }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('owner-settings.schedules.update', $branch->id)  }}"
                                    method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{method_field('PUT')}}
                                    <div class="row">


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">

                                                    {{ __('lang.time_in') }}
                                                </label>
                                                <input type="time" name="time_in"
                                                    value="{{$branch->week_availability->time_in }}"
                                                    class="form-control" placeholder="{{ __('lang.time_in') }}">
                                                @if ($errors->has('time_in'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('time_in') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.time_out') }}
                                                </label>
                                                <input type="time" name="time_out"
                                                    value="{{ $branch->week_availability->time_out }}"
                                                    class="form-control" placeholder="{{ __('lang.time_out') }}">
                                                @if ($errors->has('time_out'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('time_out') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-9">
                                            <h2 class="text-right">{{ __('lang.appointment_time') }}</h2>

                                            <div class=" form-group">
                                                <div class="row">
                                                    @foreach ($times as $time)
                                                    @if (
                                                    \Carbon\Carbon::parse($branch->week_availability->time_in)->format('Hi')
                                                    <= \Carbon\Carbon::parse($time)->format('Hi') &&
                                                        \Carbon\Carbon::parse($branch->week_availability->time_out)->format('Hi
                                                        ') >= \Carbon\Carbon::parse($time)->format('Hi') )

                                                        <div class="col-md-4">
                                                            <div class=" form-group">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        {{\Carbon\Carbon::parse($time)->format('H:i a')}}
                                                                        @php
                                                                        $i = 'time_' . $time
                                                                        @endphp
                                                                    </label>
                                                                    <input class="checkbox-input" name="{{$i}}"
                                                                        type="checkbox" data-toggle="toggle" value="1"
                                                                        {{ $branch->appointment->$i ? 'checked': '' }}>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @endif
                                                        @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <h2 class="text-right">{{ __('lang.week') }}</h2>
                                            <div class=" form-group">
                                                <div class="checkbox">
                                                    <label>
                                                        {{ __('lang.sunday') }}


                                                    </label>
                                                    <input class="checkbox-input" name="sunday" type="checkbox"
                                                        data-toggle="toggle" value="1"
                                                        {{ $branch->week_availability->sunday ? 'checked': '' }}>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label>
                                                        {{ __('lang.monday') }}


                                                    </label>
                                                    <input class="checkbox-input" name="monday" type="checkbox"
                                                        data-toggle="toggle" value="1"
                                                        {{ $branch->week_availability->monday ? 'checked': '' }}>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label>
                                                        {{ __('lang.tuesday') }}


                                                    </label>
                                                    <input class="checkbox-input" name="tuesday" type="checkbox"
                                                        data-toggle="toggle" value="1"
                                                        {{ $branch->week_availability->tuesday ? 'checked': '' }}>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label>
                                                        {{ __('lang.wednesday') }}


                                                    </label>
                                                    <input class="checkbox-input" name="wednesday" type="checkbox"
                                                        data-toggle="toggle" value="1"
                                                        {{ $branch->week_availability->wednesday ? 'checked': '' }}>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label>
                                                        {{ __('lang.thursday') }}

                                                    </label>
                                                    <input class="checkbox-input" name="thursday" type="checkbox"
                                                        data-toggle="toggle" value="1"
                                                        {{ $branch->week_availability->thursday ? 'checked': '' }}>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label>
                                                        {{ __('lang.friday') }}

                                                    </label>
                                                    <input class="checkbox-input" name="friday" type="checkbox"
                                                        data-toggle="toggle" value="1"
                                                        {{ $branch->week_availability->friday ? 'checked': '' }}>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label>
                                                        {{ __('lang.saturday') }}


                                                    </label>
                                                    <input class="checkbox-input" name="saturday" type="checkbox"
                                                        data-toggle="toggle" value="1"
                                                        {{ $branch->week_availability->saturday ? 'checked': '' }}>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-offset-10 col-md-2  ">
                                            <button type="submit"
                                                class="btn btn-primary btn-block">{{ __('lang.submit') }}</button>
                                        </div>
                                    </div>

                                </form>
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
            @endforeach

        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
    var branches = <?php echo json_encode($branches); ?>;
    var details = <?php echo json_encode($details); ?>;
    $(document).ready(function(){


        for (let i in branches) {
            if (details =='') {
                if (i !=0) {

                $("#branch-data-"+branches[i].id).hide();
            }
            } else{
                if (branches[i].id  != details) {

                    $("#branch-data-"+branches[i].id).hide();
                    }
            }

}

    });



function select() {
  var selected = document.getElementById("branch_id").value;

  for (let i of branches) {
            if (i.id != selected) {
                $("#branch-data-"+i.id).hide();
            }
            else{
                $("#branch-data-"+i.id).show();
            }

}



}
</script>
@endsection
