@extends('layouts.master')
@section('css')
@endsection

@section('title')
    @lang('dashboard.classrooms')
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0">@lang('dashboard.classrooms')</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item"><a href="#" class="default-color">Home</a></li>
                    <li class="breadcrumb-item active">@lang('dashboard.classrooms')</li>
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
                                        <button id="createClassroomBtn" class="btn btn-danger">@lang('dashboard.create_classroom')</button>
                                        <table id="datatable" class="table table-striped table-bordered p-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('dashboard.classroom_name')</th>
                                                    <th>@lang('dashboard.grade_name')</th>
                                                    <th>@lang('dashboard.created_at')</th>
                                                    <th>@lang('dashboard.updated_at')</th>
                                                    <th>@lang('dashboard.actions')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach ($classrooms as $classroom)
                                                    <tr id="classroom-{{ $classroom->id }}">
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $classroom->name }}</td>
                                                        <td>{{ $classroom->grade->name }}</td>
                                                        <td>{{ $classroom->created_at }}</td>
                                                        <td>{{ $classroom->updated_at }}</td>
                                                        <td class="d-flex gap-2">
                                                            <button class="btn btn-primary btn-sm edit-classroom"
                                                                data-id="{{ $classroom->id }}">@lang('dashboard.edit')</button>
                                                            <button class="btn btn-danger btn-sm delete-classroom"
                                                                data-id="{{ $classroom->id }}">@lang('dashboard.delete')</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('dashboard.classroom_name')</th>
                                                    <th>@lang('dashboard.grade_name')</th>
                                                    <th>@lang('dashboard.created_at')</th>
                                                    <th>@lang('dashboard.updated_at')</th>
                                                    <th>@lang('dashboard.actions')</th>
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

    <!-- Modal for Create and Edit -->
    <div class="modal fade" id="classroomModal" tabindex="-1" role="dialog" aria-labelledby="classroomModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="classroomModalLabel">Classroom</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="classroomForm">
                        @csrf
                        <input type="hidden" id="classroomId" name="classroomId">
                        <div class="form-group">
                            <label for="name">@lang('dashboard.classroom_name')</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="name_en">@lang('dashboard.english_classroom_name')</label>
                            <input type="text" class="form-control" id="name_en" name="name_en">
                        </div>
                        <div class="form-group">
                            <label for="grade_id">@lang('dashboard.grade_name')</label>
                            <select class="form-control" id="grade_id" name="grade_id">
                                <option value="">@lang('dashboard.select_grade')</option>
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">@lang('dashboard.create_classroom')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Response -->
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
            // Show the create modal
            $('#createClassroomBtn').click(function() {
                $('#classroomModalLabel').text("@lang('dashboard.create_classroom')");
                $('#classroomForm').trigger('reset');
                $('#classroomId').val('');
                $('#classroomModal').modal('show');
            });

            // Show the edit modal
            $('.edit-classroom').click(function() {
                var classroomId = $(this).data('id');
                $.get('/classroom/' + classroomId + '/edit', function(data) {
                    if (data.success) {
                        $('#classroomModalLabel').text("@lang('dashboard.edit_classroom')");
                        $('#classroomId').val(data.classroom.id);
                        $('#name').val(data.classroom.name.ar);
                        $('#name_en').val(data.classroom.name.en);
                        $('#grade_id').val(data.classroom.grade_id);
                        $('#classroomModal').modal('show');
                    }
                });
            });

            // Handle form submission for create and edit
            $('#classroomForm').submit(function(e) {
                e.preventDefault();
                var classroomId = $('#classroomId').val();
                var url = classroomId ? '/classroom/' + classroomId : '{{ route('classroom.store') }}';
                var method = classroomId ? 'PUT' : 'POST';
                $.ajax({
                    url: url,
                    method: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#responseMessage').text(response.message);
                        $('#responseModal').modal('show');
                        if (response.success) {
                            // var classroomHtml = JSON.stringify(response.classroom);
                            // alert(classroomHtml);
                            var classroomHtml = '<tr id="classroom-' + response.classroom.id +
                                '">';
                            classroomHtml += '<td>' + response.classroom.name.ar + '</td>';
                            classroomHtml += '<td>' + response.classroom.grade.name + '</td>';
                            classroomHtml += '<td>' + response.classroom.created_at + '</td>';
                            classroomHtml += '<td>' + response.classroom.updated_at + '</td>';
                            classroomHtml +=
                                '<td><button class="btn btn-primary edit-classroom" data-id="' +
                                response.classroom.id + '">Edit</button></td>';
                            classroomHtml +=
                                '<td><button class="btn btn-danger delete-classroom" data-id="' +
                                response.classroom.id + '">Delete</button></td>';
                            classroomHtml += '</tr>';

                            // Check if classroomId exists to determine if it's an update or create action
                            if (classroomId) {
                                $('#classroom-' + classroomId).replaceWith(
                                    classroomHtml); // Replace existing row with updated HTML
                            } else {
                                $('#datatable tbody').append(
                                    classroomHtml); // Append new row to the table body
                            }
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = xhr.responseJSON.message || 'An error occurred';
                        $('#responseMessage').text(errorMessage);
                        $('#responseModal').modal('show');
                    }
                });
            });

            // Handle delete button click
            $('.delete-classroom').click(function(e) {
                e.preventDefault();
                var classroomId = $(this).data('id');
                if (confirm('Are you sure you want to delete this classroom?')) {
                    $.ajax({
                        url: '/classroom/' + classroomId,
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#classroom-' + classroomId).remove();
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
