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
                                <h5 class="m-0">{{ $no . '. '}}{{ $question->question }}</h5>
                            </div>
                            <div class="card-header">
                                <h6 class="m-0">{{ $question->degree . ' Marks' }}</h6>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">{{ $question->description }}</h6>

                                <p class="card-text">With supporting text below as a natural lead-in to additional
                                    content.
                                </p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
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
