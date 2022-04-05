@extends('cms.parent')
@section('title', __('cms.change_password'))
@section('big-title', __('cms.change_password'))
@section('small-title', __('cms.change_password'))
@section('location', __('cms.password'))

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
                            <h3 class="card-title">{{ __('cms.create_room') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="change-password">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="current_password">{{ __('cms.current_password') }}</label>
                                    <input type="password" class="form-control" id="current_password" placeholder="Enter current password">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="new_password">{{ __('cms.new_password') }}</label>
                                    <input type="password" class="form-control" id="new_password" placeholder="Enter new password">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="confirmation_password">{{ __('cms.confirmation_password') }}</label>
                                    <input type="password" class="form-control" id="confirmation_password" placeholder="Enter confirmation password">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="applyChangePassword()" class="btn btn-primary">{{ __('cms.add') }}</button>
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
        function applyChangePassword() {
            axios.post('/cms/admin/change-password', {
                    current_password: document.getElementById('current_password').value,
                    new_password: document.getElementById('new_password').value,
                    confirmation_password: document.getElementById('confirmation_password').value,
                })
                .then(function(response) {
                    // handle success
                    console.log(response);
                    document.getElementById('change-password').reset();
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
