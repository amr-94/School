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
                                            @foreach ($grades as $grade)
                                                <tr>
                                                    <td>{{ $grade->id }}</td>
                                                    <td>{{ $grade->name }}</td>
                                                    <td>{{ $grade->notes }}</td>
                                                    <td>any process</td>
                                                    <td>{{ $grade->created_at }}</td>
                                                    <td>{{ $grade->updated_at }}</td>
                                                    <td class="d-flex gap-2">
                                                        <a href="{{ route('grade.edit', $grade->id) }}"
                                                            class="btn btn-primary btn-sm mr-2">Edit</a>
                                                        <form action="{{ route('grade.destroy', $grade->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
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
@endsection
@section('js')

@endsection
