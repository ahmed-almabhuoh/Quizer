@extends('cms.parent')
@section('title', __('cms.add_question'))
@section('big-title', __('cms.add_question'))
@section('small-title', __('cms.add_question'))
@section('location', __('cms.add'))

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
                            <h3 class="card-title">{{ __('cms.add_question') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="create-form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="question">{{ __('cms.question') }}</label>
                                    <input type="text" class="form-control" id="question" placeholder="Enter question title">
                                </div>
                                <div class="form-group">
                                    <label for="description">{{ 'Optional ' . __('cms.description') }}</label>
                                    <input type="text" class="form-control" id="description"
                                        placeholder="Enter question description">
                                </div>
                                <div class="form-group">
                                    <label for="degree">{{ __('cms.degree') }}</label>
                                    <input type="number" class="form-control" id="degree"
                                        placeholder="Enter question degree">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="active" checked>
                                    <label class="form-check-label" for="active">{{ __('cms.active') }}</label>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="applyAddingQuestions({{$quiz->id}})"
                                    class="btn btn-primary">{{ __('cms.add') }}</button>
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
        function applyAddingQuestions(quiz_id) {
            axios.post('/cms/admin/questions', {
                    question: document.getElementById('question').value,
                    description: document.getElementById('description').value,
                    degree: document.getElementById('degree').value,
                    active: document.getElementById('active').checked,
                    _quiz_id: quiz_id,
                })
                .then(function(response) {
                    // handle success
                    console.log(response);
                    // window.location.href = '/cms/admin/quizzes';
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
