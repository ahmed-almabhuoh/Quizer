@extends('cms.parent')
@section('title', __('cms.add_student'))
@section('big-title', __('cms.add_student'))
@section('small-title', __('cms.add_student'))
@section('location', __('cms.create'))

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
                            <h3 class="card-title">{{ __('cms.add_student') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="create-form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ __('cms.name') }}</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('cms.email') }}</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter student email">
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ __('cms.password') }}</label>
                                    <input type="text" class="form-control" id="password" placeholder="Enter student password" value="{{$password}}">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="applyAddingStudent()" class="btn btn-primary">{{ __('cms.add') }}</button>
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
        function applyAddingStudent() {
            axios.post('/cms/admin/students', {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    password: document.getElementById('password').value,
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
