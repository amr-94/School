@extends('layouts.master')
@section('css')
@section('title')
    @lang('dashboard.edit_classroom')
@stop
@endsection

@section('page-header')
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">@lang('dashboard.edit_classroom')</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">Home</a></li>
                <li class="breadcrumb-item"><a href="#" class="default-color">@lang('dashboard.classrooms')</a></li>
                <li class="breadcrumb-item active">@lang('dashboard.edit_classroom')</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-30">
        @component('components.errors')
        @endcomponent
        <div class="card card-statistics h-100">
            <div class="card-body">
                <form id="classroomForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name_ar">@lang('dashboard.arabic_classroom_name')</label>
                        <input type="text" name="name" id="name_ar" class="form-control"
                            value="{{ $classroom->getTranslation('name', 'ar') }}">
                        @error('name.ar')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name_en">@lang('dashboard.english_classroom_name')</label>
                        <input type="text" name="name_en" id="name_en" class="form-control"
                            value="{{ $classroom->getTranslation('name', 'en') }}">
                        @error('name.en')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="grade_id">@lang('dashboard.grade')</label>
                        <select name="grade_id" id="grade_id" class="form-control">
                            <option value="">Select</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade->id }}"
                                    {{ $classroom->grade_id == $grade->id ? 'selected' : '' }}>{{ $grade->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('grade_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="button" id="submitClassroomForm"
                            class="btn btn-primary">@lang('dashboard.update_classroom')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="responseModalLabel">Response</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="responseMessage">
                <!-- Response message will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#submitClassroomForm').click(function(e) {
            e.preventDefault();

            var formData = $('#classroomForm').serialize();
            var classroomId = "{{ $classroom->id }}";

            $.ajax({
                url: "{{ route('classroom.update', $classroom->id) }}",
                method: "PUT",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#responseMessage').text(response.message);
                        $('#responseModal').modal('show');
                    } else {
                        $('#responseMessage').text(response.message);
                        $('#responseModal').modal('show');
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '';
                    for (var error in errors) {
                        errorMessage += errors[error] + '\n';
                    }
                    $('#responseMessage').text(errorMessage);
                    $('#responseModal').modal('show');
                }
            });
        });
    });
</script>
@endsection
