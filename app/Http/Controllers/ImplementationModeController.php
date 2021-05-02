<?php

namespace App\Http\Controllers;

use App\DataTables\ImplementationModesDataTable;
use App\Models\ImplementationMode;
use Illuminate\Http\Request;

class ImplementationModeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ImplementationModesDataTable $dataTable)
    {
        return $dataTable->render('admin.implementation_modes.index', [
            'pageTitle' => 'Modes of Implementation',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.implementation_modes.create', [
            'pageTitle' => 'Add Implementation Mode',
        ]);
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
            'name' => 'required',
        ]);

        ImplementationMode::create($request->all());

        return redirect()->route('admin.implementation_modes.index');
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
    public function edit(ImplementationMode $implementationMode)
    {
        return view('admin.implementation_modes.edit', [
            'pageTitle' => 'Edit Implemenetation Mode',
            'implementation_mode' => $implementationMode
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImplementationMode $implementationMode)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $implementationMode->update($request->all());

        return redirect()->route('admin.implementation_modes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImplementationMode $implementationMode)
    {
        $implementationMode->delete();

        return response()->noContent();
    }
}
