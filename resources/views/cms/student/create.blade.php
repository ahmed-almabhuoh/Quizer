@extends('cms.parent')
@section('title', __('cms.create_room'))
@section('big-title', __('cms.room'))
@section('small-title', __('cms.room'))
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
                            <h3 class="card-title">{{ __('cms.create_room') }}</h3>
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
                                    <label for="description">{{ __('cms.description') }}</label>
                                    <input type="text" class="form-control" id="description" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="code">{{ __('cms.code') }}</label>
                                    <input type="text" class="form-control" id="code" placeholder="Room Code" value="{{$code}}" readonly>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="active" checked>
                                    <label class="form-check-label" for="active">{{ __('cms.active') }}</label>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="applyAddingRoom('{{$code}}')" class="btn btn-primary">{{ __('cms.add') }}</button>
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
        function applyAddingRoom(code) {
            axios.post('/cms/admin/rooms', {
                    name: document.getElementById('name').value,
                    description: document.getElementById('description').value,
                    active: document.getElementById('active').checked ? true : false,
                    _code: code,
                })
                .then(function(response) {
                    // handle success
                    console.log(response);
                    window.location.href = '/cms/admin/rooms';
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
