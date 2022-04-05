@extends('cms.parent')
@section('title', __('cms.update_student'))
@section('big-title', __('cms.update_student'))
@section('small-title', __('cms.update_student'))
@section('location', __('cms.update'))

@section('styles')

@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('cms.update_student') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="create-form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ __('cms.name') }}</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter student name" value="{{$student->name}}">
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('cms.email') }}</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter student email" value="{{$student->email}}">
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ __('cms.password') }} 'Optional'</label>
                                    <input type="text" class="form-control" id="password" placeholder="Enter new password">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="applyEditingStudent({{$student->id}})" class="btn btn-primary">{{ __('cms.edit') }}</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('scripts')
    <script>
        function applyEditingStudent(id) {
            axios.put('/cms/admin/students/' + id, {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    password: document.getElementById('password').value == '' ? 'password' : document.getElementById('password').value,
                })
                .then(function(response) {
                    // handle success
                    console.log(response);
                    window.location.href = '/cms/admin/students';
                    document.getElementById('create-form').reset();
                    toastr.success(response.data.message);
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    toastr.error(error.response.data.message)
                    // window.location.href = '/tusaned-cpanel/logout';
                })
                .then(function() {
                    // always executed
                });
        }
    </script>
@endsection
