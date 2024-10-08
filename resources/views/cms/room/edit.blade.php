@extends('cms.parent')
@section('title', __('cms.update_room'))
@section('big-title', __('cms.update_room'))
@section('small-title', __('cms.update_room'))
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
                            <h3 class="card-title">{{ __('cms.update_room') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ __('cms.name') }}</label>
                                    <input type="text" class="form-control" id="name" value="{{$room->name}}" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="description">{{ __('cms.description') }}</label>
                                    <input type="text" class="form-control" id="description" value="{{$room->description}}" placeholder="Enter room description">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="active"
                                        @if ($room->active)
                                            checked
                                        @endif
                                    >
                                    <label class="form-check-label" for="active">{{ __('cms.active') }}</label>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="applyUpdatingRoom({{$room->id}})" class="btn btn-primary">{{ __('cms.add') }}</button>
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
        function applyUpdatingRoom(id) {
            axios.put('/cms/admin/rooms/' + id, {
                    name: document.getElementById('name').value,
                    description: document.getElementById('description').value,
                    active: document.getElementById('active').checked ? true : false,
                })
                .then(function(response) {
                    // handle success
                    console.log(response);
                    window.location.href = '/cms/admin/rooms';
                    // document.getElementById('update-form').reset();
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
