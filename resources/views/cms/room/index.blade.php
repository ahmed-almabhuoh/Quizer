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
                                            <td>{{ $no . '.' }}</td>
                                            <td>{{ $room->name }}</td>
                                            <td>{{ $room->description }}</td>
                                            <td>{{ $room->code }}</td>
                                            {{-- <td>
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar @if ($room->status_room) progress-bar-success @else progress-bar-danager @endif" style="width: 55%"></div>
                                                </div>s
                                            </td> --}}
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-info">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" onclick="confirmDestroy({{$room->id}}, this)" class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <a href="{{ route('add.student.to.room', $room->id) }}" class="btn btn-info">
                                                        Student
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
    <script>
        function confirmDestroy(id, refranec) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    destroy(id, refranec);
                }
            });
        }

        function destroy(id, refranec) {
            // cms/admin/rooms/{room} 
            axios.delete('/cms/admin/rooms/' + id)
                .then(function(response) {
                    // handle success
                    console.log(response);
                    refranec.closest('tr').remove();
                    showDeletingResult(response.data);
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    showDeletingResult(error.response.data);
                })
                .then(function() {
                    // always executed
                });
        }

        function showDeletingResult(data) {
            Swal.fire({
                icon: data.icon,
                title: data.title,
                text: data.text,
                showConfirmButton: false,
                timer: 2000
            });
        }
    </script>
@endsection
