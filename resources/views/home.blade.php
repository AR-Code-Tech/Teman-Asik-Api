@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <!-- content-header -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Beranda</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
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
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ \App\Models\Transportation::count() }}</h3>
                                    <p>Angkot</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bus"></i>
                                </div>
                                <a href="{{ route('admin.transportations.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ \App\Models\User::where('role_type', 'Driver')->count() }}</h3>
                                    <p>Driver</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <a href="{{ route('admin.drivers.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ \App\Models\Terminal::count() }}</h3>
                                    <p>Halte</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-map"></i>
                                </div>
                                <a href="{{ route('admin.terminals.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
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