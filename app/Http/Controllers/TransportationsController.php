<?php

namespace App\Http\Controllers;

use App\Models\Transportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransportationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $e = Transportation::query();
            return DataTables::of($e)->make();
        }
        return view('pages.transportations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.transportations.create');
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
            'description' => 'required|string|min:3'
        ]);

        DB::transaction(function () use ($request) {
            Transportation::create($request->only('name', 'description'));
        });

        return redirect()->route('admin.transportations.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menambahkan.']);
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
    public function edit(Transportation $transportation)
    {
        return view('pages.transportations.edit', compact('transportation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transportation $transportation)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'description' => 'required|string|min:3',
            'routes' => 'required|json'
        ]);

        DB::transaction(function () use ($request, $transportation) {
            $transportation->routes()->delete();
            $transportation->update($request->only('name', 'description'));
            $routes = json_decode($request->routes);
            foreach ($routes as $item) {
                $transportation->routes()->create([
                    'latitude' => $item->latitude,
                    'longitude' => $item->longitude,
                ]);
            }
        });

        return redirect()->route('admin.transportations.index')->with('message', ['type' => 'success', 'text' => 'Berhasil mengubah.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transportation $transportation)
    {
        $transportation->delete();
        return redirect()->route('admin.transportations.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menghapus.']);
    }
}
