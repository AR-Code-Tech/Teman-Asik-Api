@extends('adminlte::page')

@section('title', 'Driver')

@section('content_header')
    <!-- content-header -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Driver</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Driver</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ route('admin.drivers.create') }}" class="btn btn-primary">Tambah</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-header:end -->
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="mt-2">
                    <!-- flush message error -->
                    <x-message /> 
                    <!-- flush message error:end -->
                    <table id="table" class="table table-hover table-stripped">
                        <thead>
                            <th>Nama</th>
                            <th width="15%" class="text-center">...</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
        const datatablesUrl = "{{ route('admin.drivers.index') }}";
        const datatables = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: datatablesUrl,
            responsive: true,
            autoWidth: false,
            order: [[0, 'asc']],
            columns: [
                {
                    data: 'name'
                },
                {
                    data: null,
                    render: (data, type, row) => {
                        return `
                        <div class="text-center">
                            <a class="btn btn-sm btn-outline-warning" href="${datatablesUrl}/${row.id}/edit">
                                <i class="fa fa-fw fa-pen"></i>
                            </a>
                            <form action="${datatablesUrl}/${row.id}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="beforeDelete(event)"><i class="fa fa-fw fa-trash"></i></button>
                            </form>
                        </div>
                        `
                    }
                },
            ]
        });
    </script>
@stop