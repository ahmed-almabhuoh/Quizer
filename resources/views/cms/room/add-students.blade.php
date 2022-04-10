@extends('cms.parent')
@section('title', __('cms.add_student'))
@section('big-title', __('cms.add_student'))
@section('small-title', __('cms.add_student'))
@section('location', __('cms.add'))

@section('styles')
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('quizer/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('cms.add_student') }}</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student</th>
                                        <th>Room</th>
                                        <th>Settings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($students as $student)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $room->name }}</td>
                                            <td>
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="students_{{ $student->id }}"
                                                        onchange="addStudentToRoom({{ $room->id }}, {{ $student->id }})"
                                                        @foreach ($srudent_class as $student_c)
                                                            @if ($student_c->student_id == $student->id)
                                                                checked
                                                            @endif
                                                        @endforeach
                                                        >
                                                    <label for="students_{{ $student->id }}">
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                            ++$no;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
        function addStudentToRoom(room_id, student_id) {
            // /add-student-to-room/{room}/room
            axios.post('/cms/admin/add-student-to-room/' + room_id + '/room', {
                    student_id: student_id,
                })
                .then(function(response) {
                    // handle success
                    console.log(response);
                    toastr.success(response.data.message);
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    toastr.error(error.response.data.message)
                })
                .then(function() {
                    // always executed
                });
        }
    </script>
@endsection
