<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Transportation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class DriversController extends Controller
{
    private $routeName = 'drivers';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $e = User::where('role_type', 'Driver');
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
        $transportations = Transportation::all();
        return view("pages.{$this->routeName}.create", compact('transportations'));
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
            'username' => 'required|string|min:3',
            'password' => 'required|confirmed|min:6',
            'identity_number' => 'required|string',
            'plate_number' => 'required|string',
            'transportation_id' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request) {
            $user = $request->only('name', 'username');
            $user['password'] = Hash::make($request->password);
            $driver = Driver::create($request->only('transportation_id', 'identity_number', 'plate_number'));
            $driver->user()->create($user);
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
    public function edit(User $driver)
    {
        $driver->load('role');
        $transportations = Transportation::all();
        return view("pages.{$this->routeName}.edit", compact('driver', 'transportations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $driver)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'identity_number' => 'required|string',
            'plate_number' => 'required|string',
            'transportation_id' => 'required|numeric',
        ]);
        if ($request->username != $driver->username) $request->validate(['username' => 'required|string|min:3|unique:users']);
        if ($request->has('password') && $request->password != '') $request->validate(['password' => 'required|confirmed|min:6']);

        DB::transaction(function () use ($request, $driver) {
            $user = $request->only('name');
            if ($request->username != $driver->username) $user['username'] = $request->username;
            if ($request->has('password') && $request->password != '') $user['password'] = Hash::make($request->password);
            $driver->update($user);
            $driver->role()->update($request->only('transportation_id', 'identity_number', 'plate_number'));
        });

        return redirect()->route("admin.{$this->routeName}.index")->with('message', ['type' => 'success', 'text' => 'Berhasil mengubah.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $driver)
    {
        DB::transaction(function () use ($driver) {
            $driver->role()->delete();
            $driver->delete();
        });
        return redirect()->route("admin.{$this->routeName}.index")->with('message', ['type' => 'success', 'text' => 'Berhasil menghapus.']);
    }
}
