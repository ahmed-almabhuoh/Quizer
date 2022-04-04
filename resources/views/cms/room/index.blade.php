@extends('cms.parent')
@section('title', __('cms.rooms'))
@section('big-title', __('cms.rooms'))
@section('small-title', __('cms.rooms'))
@section('location', __('cms.index'))

@section('styles')

@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('cms.rooms') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('cms.name') }}</th>
                                        <th>{{ __('cms.description') }}</th>
                                        <th>{{ __('cms.code') }}</th>
                                        {{-- <th style="width: 40px">{{ __('cms.status') }}</th> --}}
                                        <th>{{ __('cms.settings') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($rooms as $room)
                                        <tr>
                                            <td>{{$no . '.'}}</td>
                                            <td>{{$room->name}}</td>
                                            <td>{{$room->description}}</td>
                                            <td>{{$room->code}}</td>
                                            {{-- <td>
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar @if($room->status_room) progress-bar-success @else progress-bar-danager @endif" style="width: 55%"></div>
                                                </div>s
                                            </td> --}}
                                            <td></td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        {{-- <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item"><a class="page-link" href="#">«</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">»</a></li>
                            </ul>
                        </div> --}}
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('scripts')

@endsection
