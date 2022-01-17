@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('settings.questions.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.questions') }} 
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.question') }}
                                    </label>
                                    <textarea class="form-control" name="question" rows="3"></textarea>
                                    @if ($errors->has('question'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('question') }}</strong>
                                        </span> 
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        {{ __('lang.answer') }}
                                    </label>
                                    <textarea class="form-control" name="answer" rows="5"></textarea>
                                    @if ($errors->has('answer'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('answer') }}</strong>
                                        </span> 
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('settings.questions.index') }}" class="btn btn-inverse-primary "> 
                          {{ __('lang.back') }}
                        </a>
                        <button type="submit" class="btn btn-primary float-right">{{ __('lang.submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection