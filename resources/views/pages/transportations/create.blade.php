@extends('adminlte::page')

@section('title', 'Angkot - Tambah')

@section('content_header')
    <!-- content-header -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Angkot</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.transportations.index') }}">Angkot</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ route('admin.transportations.index') }}" class="btn btn-danger">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-header:end -->
@stop

@section('content')
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-12">
                    <div class="mt-2">
                        <!-- flush message error -->
                        <x-message /> 
                        <!-- flush message error:end -->
                        <form action="{{ route('admin.transportations.store') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-right">Nama</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-fw fa-id-card"></i>
                                        </span>
                                        <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Nama">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-right">Deskripsi</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <textarea name="description" class="form-control" autocomplete="off" placeholder="Deskripsi"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <div class="offset-md-4 col-md-4">
                                    <button class="btn btn-primary">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop