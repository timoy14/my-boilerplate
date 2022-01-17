@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('services.services.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.privates') }}
                    </div>
                    <div class="card-body">

                        <h4 class="my-3 text-right">{{ __('lang.service_information') }}</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.owners') }}
                                    </label>
                                    <select name="owner_id" class="form-control" dir="rtl" disabled>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ ($service->user_id == $user->id ) ? 'selected':'' }}>{{ $user->name }} -
                                            #{{ $user->id }} </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('owner_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('owner_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Type City -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.types') }}
                                    </label>
                                    <select name="type_id" class="form-control" dir="rtl" disabled>
                                        @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            {{ ($service->type_id == $type->id ) ? 'selected':'' }}>
                                            {{ (session()->get('locale') === 'ar') ? $type->ar: $type->en }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('type_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('type_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.cities') }}
                                    </label>
                                    <select name="city_id" class="form-control" dir="rtl" disabled>
                                        @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ ($service->city_id == $type->id ) ? 'selected':'' }}>
                                            {{ (session()->get('locale') === 'ar') ? $city->ar: $city->en }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('city_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('city_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- User And area -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.areas') }}
                                    </label>
                                    <select name="area_id" class="form-control" dir="rtl" disabled>
                                        @foreach ($areas as $area)
                                        <option value="{{ $area->id }}" {{ ($service->area_id == $area->id) ?
                                 'selected': '' }}>
                                            {{ (session()->get('locale') === 'ar') ? $area->ar: $area->en }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('area_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('area_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.name') }}
                                    </label>
                                    <input type="text" name="name" value="{{$service->name}}" class="form-control"
                                        autocomplete="off" disabled>
                                    @if ($errors->has('name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- LatLong -->
                        <div class="row my-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="https://www.google.com/maps/place/{{$service->latitude}}+{{$service->longitude}}/"
                                        target="_blank" class="btn btn-danger btn-block">
                                        <i class="fa fa-map"></i> {{ __('lang.view_map') }}</a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="hidden" name="latitude" value="{{ old('latitude') }}" class="latitude">
                                    <input type="text" value="{{$service->latitude}}" class="latitude form-control"
                                        placeholder="{{ __('lang.latitude') }}" disabled>
                                    @if ($errors->has('latitude'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('latitude') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="hidden" name="longitude" value="{{ old('longitude') }}"
                                        class="longtitude">
                                    <input type="text" value="{{$service->longitude}}" class="longtitude form-control"
                                        placeholder="{{ __('lang.longtitude') }}" disabled>
                                    @if ($errors->has('longitude'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('longitude') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <!-- Description -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.description') }}
                                    </label>
                                    <textarea class="form-control" name="description" rows="3"
                                        disabled>{{$service->description}}</textarea>
                                    @if ($errors->has('description'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Contact Name And Contact Num. -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.contact_no') }}
                                    </label>
                                    <input type="text" maxlength="10" name="contact_no" value="{{$service->contact_no}}"
                                        class="form-control" autocomplete="off" disabled>
                                    @if ($errors->has('contact_no'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('contact_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.contact_name') }}
                                    </label>
                                    <input type="text" name="contact_name" value="{{$service->contact_name}}"
                                        class="form-control" autocomplete="off" disabled>
                                    @if ($errors->has('contact_name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('contact_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.proof_of_ownership') }}
                                    </label>
                                    <br />
                                    <ul class="list-unstyled">
                                        <li>
                                            @if($service->proof_of_ownership)
                                            <a href="{{ asset('storage/'.$service->proof_of_ownership )}}"
                                                target="_blank">
                                                {{ __('lang.click_here_to_view_full_image') }}</a></a>
                                            @else
                                            <span class="badge badge-success">{{ __('lang.no_image') }}</span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <h4 class="my-3 text-right">{{ __('lang.facilities') }}</h4>
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <table id="seasonal_prices" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('lang.value') }} </th>
                                                <th>{{ __('lang.avatar') }} </th>
                                                <th>{{ __('lang.name') }} </th>
                                            </tr>
                                            @foreach ($facilities as $facility)
                                            <tr>
                                                <td>

                                                    {{ $facility->value }}

                                                </td>
                                                <td>
                                                    @if($facility->facility->type == 'boolean')
                                                    <span class="badge badge-success">{{ __('lang.no_image') }}</span>
                                                    @else
                                                    <img src="{{ ($facility->facility->avatar) ? asset('storage/'.$facility->facility->avatar): asset('images/defaults/intro-default.png') }}"
                                                        width="30px" height="25px">

                                                    @endif
                                                </td>
                                                <td>{{ (session()->get('locale') === 'ar') ? $facility->facility->ar: $facility->facility->en }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <h4 class="my-3 text-right">{{ __('lang.general_price') }}</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <table id="seasonal_prices" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('lang.sunday') }}</th>
                                                <th>{{ __('lang.saturday') }}</th>
                                                <th>{{ __('lang.friday') }}</th>
                                                <th>{{ __('lang.thursday') }}</th>
                                                <th>{{ __('lang.wednesday') }}</th>
                                                <th>{{ __('lang.tuesday') }}</th>
                                                <th>{{ __('lang.monday') }}</th>
                                            </tr>
                                            @foreach ($general_prices as $general_price)
                                            <tr>
                                                <td>{{ $general_price->sunday}}</td>
                                                <td>{{ $general_price->saturday }}</td>
                                                <td>{{ $general_price->friday }}</td>
                                                <td>{{ $general_price->thursday }}</td>
                                                <td>{{ $general_price->wednesday }}</td>
                                                <td>{{ $general_price->tuesday }}</td>
                                                <td>{{ $general_price->monday }}</td>
                                            </tr>
                                            @endforeach
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <h4 class="my-3 text-right">{{ __('lang.seasonal_price') }}</h4>
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <table id="seasonal_prices" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('lang.sunday') }}</th>
                                                <th>{{ __('lang.saturday') }}</th>
                                                <th>{{ __('lang.friday') }}</th>
                                                <th>{{ __('lang.thursday') }}</th>
                                                <th>{{ __('lang.wednesday') }}</th>
                                                <th>{{ __('lang.tuesday') }}</th>
                                                <th>{{ __('lang.monday') }}</th>

                                                <th>{{ __('lang.to') }} </th>
                                                <th>{{ __('lang.from') }} </th>

                                            </tr>
                                            @foreach ($seasonal_prices as $price)
                                            <tr>
                                                <td>{{ $price->sunday}}</td>
                                                <td>{{ $price->saturday}}</td>
                                                <td>{{ $price->friday}}</td>
                                                <td>{{ $price->thursday}}</td>
                                                <td>{{ $price->wednesday}}</td>
                                                <td>{{ $price->tuesday}}</td>
                                                <td>{{ $price->monday}}</td>
                                                <td>{{ $price->to}}</td>
                                                <td>{{ $price->from}}</td>
                                            </tr>
                                            @endforeach
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <h4 class="my-3 text-right">{{ __('lang.availability') }}</h4>
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <table id="seasonal_prices" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('lang.to') }} </th>
                                                <th>{{ __('lang.from') }} </th>
                                            </tr>
                                            @foreach ($service->availablities as $availability)
                                            <tr>
                                                <td>{{ $availability->to }}</td>
                                                <td>{{ $availability->from }}</td>
                                            </tr>
                                            @endforeach
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <h4 class="my-3 text-right">{{ __('lang.images') }}</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <ul class="list-unstyled">
                                        @if(!$service->images->isEmpty())
                                        @foreach ($service->images as $image)
                                        <li><a href="{{ asset('storage/'.$image->avatar )}}"
                                                target="_blank">{{ __('lang.click_here_to_view_full_image') }}</a>
                                        </li>
                                        @endforeach
                                        @else
                                        <span class="badge badge-success">{{ __('lang.no_image') }}</span>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ URL::previous() }}" class="btn btn-inverse-primary float-right">
                            {{ __('lang.back') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection


@section('script')
@endsection
