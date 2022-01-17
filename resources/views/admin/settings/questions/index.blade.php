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
                            <a href="{{ route('settings.questions.create')}}"
                                class="btn btn-success btn-round btn-md mt-2">{{ __('lang.questions') }} <i
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
                                    <th>{{ __('lang.answer') }}</th>
                                    <th>{{ __('lang.question') }}</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $question)
                                <tr>
                                    <td width="5%">
                                        <form action="{{ route('settings.questions.destroy', $question->id) }}"
                                            class="wbd-form" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-round btn-sm">
                                                {{ __('lang.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                    <td width="5%">
                                        <a href="{{ route('settings.questions.edit' , $question->id )}}"
                                            class="btn btn-warning btn-round btn-sm">
                                            {{ __('lang.update') }}
                                        </a>
                                    </td>
                                    <td width="5%">
                                        <button class="btn btn-info btn-round btn-sm" data-toggle="modal"
                                            data-target="#ViewModal" data-answer="{{ $question->answer }}"
                                            data-question="{{ $question->question }}">
                                            {{ __('lang.view') }}
                                        </button>
                                    </td>
                                    <td>{!! Str::limit($question->answer, 20, ' ...') !!}</td>
                                    <td>{!! Str::limit($question->question, 20, ' ...') !!}</td>
                                    <td>{{ $question->id }}</td>
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
                <h5 class="modal-title float-right">{{ __('lang.questions') }}</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.question') }}
                                </label>
                                <textarea class="form-control" name="question" rows="3" id="question"
                                    disabled></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.answer') }}
                                </label>
                                <textarea class="form-control" name="answer" rows="5" id="answer" disabled></textarea>
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
      var answer = $(e.relatedTarget).data('answer');
      var question = $(e.relatedTarget).data('question');
      $(e.currentTarget).find('textarea[id="answer"]').html(answer);
      $(e.currentTarget).find('textarea[id="question"]').html(question);
    });

  });
</script>
@endsection
