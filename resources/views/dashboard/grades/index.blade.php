@extends('layouts.master')
@section('css')

@section('title')
    @lang('dashboard.grades')
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">@lang('dashboard.grades')</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">Home</a></li>
                <li class="breadcrumb-item active">@lang('dashboard.grades')</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
@include('components.alert')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-12 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <a href="{{ route('grade.create') }}" class="btn btn-danger">@lang('dashboard.create_grade')</a>
                                    <table id="datatable" class="table table-striped table-bordered p-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Grade Name</th>
                                                <th>Notes</th>
                                                <th>Process</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($grades as $grade)
                                                <tr id="grade-{{ $grade->id }}">
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $grade->name }}</td>
                                                    <td>{{ $grade->notes }}</td>
                                                    <td>any process</td>
                                                    <td>{{ $grade->created_at }}</td>
                                                    <td>{{ $grade->updated_at }}</td>
                                                    <td class="d-flex gap-2">
                                                        <a href="{{ route('grade.edit', $grade->id) }}"
                                                            class="btn btn-primary btn-sm mr-2">Edit</a>
                                                        <button class="btn btn-danger btn-sm delete-grade"
                                                            data-id="{{ $grade->id }}">Delete</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Grade Name</th>
                                                <th>Notes</th>
                                                <th>Process</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->

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
        // Handle delete button click
        $('.delete-grade').click(function(e) {
            e.preventDefault();

            var gradeId = $(this).data('id');

            if (confirm('Are you sure you want to delete this grade?')) {
                $.ajax({
                    url: "{{ route('grade.destroy', $grade->id) }}",
                    method: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#grade-' + gradeId).remove();
                        }
                        $('#responseMessage').text(response.message);
                        $('#responseModal').modal('show');
                    },
                    error: function(xhr) {
                        var errorMessage = xhr.responseJSON.message || 'An error occurred';
                        $('#responseMessage').text(errorMessage);
                        $('#responseModal').modal('show');
                    }
                });
            }
        });
    });
</script>
@endsection
