@extends('cms.parent')
@section('title', __('cms.questions') . '')
@section('big-title', __('cms.questions'))
@section('small-title', __('cms.questions'))
@section('location', __('cms.index'))

@section('styles')

@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @php
                    $no = 1;
                @endphp
                @foreach ($quiz->questions as $question)
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">{{ $no . '. ' }}{{ $question->question }}</h5>
                            </div>
                            <div class="card-header">
                                <h6 class="m-0">{{ $question->degree . ' Marks' }}</h6>
                            </div>
                            <div class="card-header">
                                @if (!is_null($question->description))
                                    <h4>note</h4>
                                    <h6 class="card-title">{{ $question->description }}</h6>
                                @endif
                            </div>
                            <div class="card-body">
                                @foreach ($question->answers as $answer)
                                    @if ($answer->is_answer)
                                        <p style="background-color: green;color: white; padding: 5px;">
                                            {{ $answer->answer }}</p>
                                    @else
                                        <p>{{ $answer->answer }}</p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @php
                        ++$no;
                    @endphp
                @endforeach
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('scripts')

@endsection
