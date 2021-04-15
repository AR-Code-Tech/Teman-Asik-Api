@extends('adminlte::page')

@section('title', 'Driver - Tambah')

@section('content_header')
    <!-- content-header -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Driver</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.drivers.index') }}">Driver</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ route('admin.drivers.index') }}" class="btn btn-danger">Batal</a>
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
                        <form action="{{ route('admin.drivers.store') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-right">Nama</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Nama" value="{{ old('name') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-right">Username</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-fw fa-user"></i>
                                        </span>
                                        <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Username" value="{{ old('username') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-right">Angkot</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-fw fa-bus"></i>
                                        </span>
                                        <select name="transportation_id" class="form-control" autocomplete="off" placeholder="Angkot">
                                            <option value="">-- Pilih Angkot --</option>
                                            @foreach ($transportations as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-right">Nomor KTP</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-fw fa-id-card"></i>
                                        </span>
                                        <input type="text" name="identity_number" class="form-control" autocomplete="off" placeholder="Nomor KTP" value="{{ old('identity_number') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-right">Nomor Plat</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" name="plate_number" class="form-control" autocomplete="off" placeholder="Nomor Plat" value="{{ old('plate_number') }}">
                                    </div>
                                </div>
                            </div>
                            {{-- <hr>
                            <div class="form-group row my-2">
                                <div class="offset-md-4 col-md-4">
                                    <p>*nb : Isi jika ingin mengganti, jika tidak kosongi saja.</p>
                                </div>
                            </div> --}}
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-fw fa-lock"></i>
                                        </span>
                                        <input type="text" name="password" class="form-control" autocomplete="off" placeholder="Password">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-right">Re-Password</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-fw fa-lock"></i>
                                        </span>
                                        <input type="text" name="password_confirmation" class="form-control" autocomplete="off" placeholder="Re-Password">
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