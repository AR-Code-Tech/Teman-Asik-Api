<?php

namespace App\Http\Controllers;

use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TerminalsController extends Controller
{
    private $routeName = 'terminals';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $e = Terminal::query();
            return DataTables::of($e)->make();
        }
        return view("pages.{$this->routeName}.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.{$this->routeName}.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'latitude' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'longitude' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        DB::transaction(function () use ($request) {
            Terminal::create($request->only('name', 'latitude', 'longitude'));
        });

        return redirect()->route("admin.{$this->routeName}.index")->with('message', ['type' => 'success', 'text' => 'Berhasil menambahkan.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Terminal $terminal)
    {
        return view("pages.{$this->routeName}.edit", compact('terminal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Terminal $terminal)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request, $terminal) {
            $terminal->update($request->only('name', 'latitude', 'longitude'));
        });

        return redirect()->route("admin.{$this->routeName}.index")->with('message', ['type' => 'success', 'text' => 'Berhasil mengubah.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Terminal $terminal)
    {
        $terminal->delete();
        return redirect()->route("admin.{$this->routeName}.index")->with('message', ['type' => 'success', 'text' => 'Berhasil menghapus.']);
    }
}
