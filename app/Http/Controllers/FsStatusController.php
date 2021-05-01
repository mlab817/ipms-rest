<?php

namespace App\Http\Controllers;

use App\DataTables\FsStatusesDataTable;
use App\Models\FsStatus;
use Illuminate\Http\Request;

class FsStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FsStatusesDataTable $dataTable)
    {
        return $dataTable->render('admin.fs_statuses.index', [
            'pageTitle' => 'Feasibility Study Statuses',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.fs_statuses.create', [
            'pageTitle' => 'Add FS Status',
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

        FsStatus::create($request->all());

        return redirect()->route('admin.fs_statuses.index');
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
    public function edit(FsStatus $fsStatus)
    {
        return view('admin.fs_statuses.edit', [
            'fs_status' => $fsStatus,
            'pageTitle' => 'Edit FS Status',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FsStatus $fsStatus)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $fsStatus->update($request->all());

        return redirect()->route('admin.fs_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
