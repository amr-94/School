@extends('layouts.master')
@section('css')
@section('title')
    @lang('dashboard.edit_grade')
@stop
@endsection

@section('page-header')
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">@lang('dashboard.edit_grade')</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">Home</a></li>
                <li class="breadcrumb-item"><a href="#" class="default-color">@lang('dashboard.grades')</a></li>
                <li class="breadcrumb-item active">@lang('dashboard.edit_grade')</li>
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
                <form id="gradeUpdateForm">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label for="name_ar">@lang('dashboard.arabic_grade_name')</label>
                        <input type="text" name="name" id="name_ar" class="form-control"
                            value="{{ $grade->getTranslation('name', 'ar') }}">
                        @error('name.ar')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name_en">@lang('dashboard.english_grade_name')</label>
                        <input type="text" name="name_en" id="name_en" class="form-control"
                            value="{{ $grade->getTranslation('name', 'en') }}">
                        @error('name.en')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="notes">@lang('dashboard.notes')</label>
                        <textarea name="notes" id="notes" class="form-control">{{ $grade->notes }}</textarea>
                        @error('notes')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="button" id="submitGradeUpdateForm"
                            class="btn btn-primary">@lang('dashboard.update_grade')</button>
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
        $('#submitGradeUpdateForm').click(function(e) {
            e.preventDefault();

            var formData = $('#gradeUpdateForm').serialize();
            $.ajax({
                url: "{{ route('grade.update', $grade->id) }}",
                method: "POST",
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

            });
        });
    });
</script>
@endsection
