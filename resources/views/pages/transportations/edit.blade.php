@extends('adminlte::page')

@section('title', 'Angkot - Edit')

@section('content_header')
    <!-- content-header -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Angkot</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.transportations.index') }}">Angkot</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <button type="button" class="btn btn-primary" @click="beforeSubmit">Simpan</button>
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
                        <form id="myForm" action="{{ route('admin.transportations.update', ['transportation' => $transportation->id]) }}" method="POST" autocomplete="off">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="routes" value="[]">
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-right">Nama</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-fw fa-id-card"></i>
                                        </span>
                                        <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Nama" value="{{ $transportation->name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-right">Harga</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-fw fa-id-card"></i>
                                        </span>
                                        <input type="number" name="cost" class="form-control" autocomplete="off" placeholder="Harga" value="{{ (int) $transportation->cost }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-sm-4 col-form-label text-md-right">Deskripsi</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <textarea name="description" class="form-control" autocomplete="off" placeholder="Deskripsi">{{ $transportation->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row my-2">
                                <div class="offset-md-2 col-md-8">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Rute - List</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Rute - Json</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="linestring-tab" data-toggle="tab" href="#linestring" role="tab" aria-controls="linestring" aria-selected="false">Rute - Line String (Google Earth KML)</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            <button type="button" class="btn btn-sm btn-success mt-4" @click="addNew"><i class="fa fa-fw fa-plus"></i></button>
                                            <table class="table table-sm table-bordered mt-2">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" class="text-center">#</th>
                                                        <th>Kordinat</th>
                                                        <th width="10%" class="text-center">...</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, i) in routes">
                                                        <td class="text-center">@{{ i+1 }}</th>
                                                        <td class="input-group input-group-sm">
                                                            <input type="text" name="latitude" class="form-control" autocomplete="off" placeholder="Latitude" v-model="routes[i].latitude">
                                                            <span class="input-group-text input-group-text-sm">
                                                                ,
                                                            </span>
                                                            <input type="text" name="longitude" class="form-control" autocomplete="off" placeholder="Longitude" v-model="routes[i].longitude">
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-danger" @click="deleteData(i)"><i class="fa fa-fw fa-times"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                            <textarea class="form-control mt-4" v-model="routesJSON" rows="30"></textarea>
                                        </div>
                                        <div class="tab-pane fade" id="linestring" role="tabpanel" aria-labelledby="linestring-tab">
                                            <textarea class="form-control mt-4" v-model="routesLineString" rows="30"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <div class="offset-md-4 col-md-4">
                                    <button type="button" class="btn btn-primary" @click="beforeSubmit">
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
    <style>
    .input-group-text-sm {
        padding-top: 0!important;
    }
    </style>
@stop

@section('js')
    <script>
        var routes = @JSON($transportation->routes);
        var app = new Vue({
            el: '#app',
            data() {
                return {
                    routes,
                    routesJSON: "",
                    routesLineString: "",
                }
            },
            methods: {
                addNew() {
                    this.routes.push({
                        latitude: parseFloat(0),
                        longitude: parseFloat(0),
                    });
                    this.routesJSON = this.syntaxHighlight(this.routes);
                    this.routesLineString = this.formatLineString(this.routes);
                },
                deleteData(index) {
                    this.routes.splice(index, 1);
                    this.routesJSON = this.syntaxHighlight(this.routes);
                    this.routesLineString = this.formatLineString(this.routes);
                },
                formatLineString(routes = []) {
                    var result = '';
                    var i = 0;
                    routes.forEach(e => {
                        result += (i == routes.length-1) ? `${e.latitude},${e.longitude}` : `${e.latitude},${e.longitude} `
                        i++;
                    });
                    return result;
                },
                checkValidJson(json) {
                    try {
                        JSON.parse(json);
                    } catch (e) {
                        console.log(e)
                        return false;
                    }
                    return true;
                },
                beforeSubmit() {
                    $('#myTab li:first-child a').tab('show');
                    var $this = this;
                    var a = setTimeout(function () {
                        if (!$this.checkValidJson($this.routesJSON)) {
                            $('#myTab li:nth-child(2) a').tab('show');
                            return alert('JSON Gagal DiProses! Pastikan tidak ada salah penulisan dalam json.');
                        }
                        var res = $this.routes.map(function(e) {
                            return {
                                latitude: parseFloat(e.latitude),
                                longitude: parseFloat(e.longitude),
                            };
                        });
                        document.querySelector("input[name='routes']").value = JSON.stringify(res);
                        document.querySelector("#app form#myForm").submit();
                    }, 500);
                },
                syntaxHighlight(obj) {
                    obj = obj.map(function(e) {
                        return {
                            latitude: parseFloat(e.latitude),
                            longitude: parseFloat(e.longitude),
                        };
                    });
                    return JSON.stringify(obj,null,2);
                    if (typeof json != 'string') {
                        json = JSON.stringify(json, undefined, 2);
                    }
                    json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                    return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
                        var cls = 'number';
                        if (/^"/.test(match)) {
                            if (/:$/.test(match)) {
                                cls = 'key';
                            } else {
                                cls = 'string';
                            }
                        } else if (/true|false/.test(match)) {
                            cls = 'boolean';
                        } else if (/null/.test(match)) {
                            cls = 'null';
                        }
                        return `"${cls}": "${match}"`;
                    });
                }
            },
            mounted() {
                this.routes = this.routes.map(function(e) {
                    return {
                        latitude: e.latitude,
                        longitude: e.longitude
                    };
                });
                this.routesJSON = this.syntaxHighlight(this.routes);
                this.routesLineString = this.formatLineString(this.routes);
                var $this = this;
                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    if (e.target.id != 'profile-tab') {
                        if (!$this.checkValidJson($this.routesJSON)) {
                            $('#myTab li:last-child a').tab('show')
                            return alert('JSON Gagal DiProses! Pastikan tidak ada salah penulisan dalam json.');
                        } else {
                            $this.routes = JSON.parse($this.routesJSON);
                        }
                    }
                    if (e.target.id != 'linestring-tab' && e.relatedTarget.id == 'linestring-tab') {
                        var a = $this.routesLineString.split(' ')
                        var b = [];
                        a.forEach((e) => {
                            c = e.split(',');
                            if (c[0] == '' || c[1] == '' || c[2] == '') return ;
                            b.push({
                                latitude: c[1],
                                longitude: c[0],
                            })
                        })
                        $this.routes = b;
                    }
                    $this.routesJSON = $this.syntaxHighlight($this.routes);
                    $this.routesLineString = $this.formatLineString($this.routes);
                })
            }
        });
    </script>
@stop