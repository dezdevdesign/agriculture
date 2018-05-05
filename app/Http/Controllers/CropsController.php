<?php

namespace App\Http\Controllers;

use App\Crop;
use Illuminate\Http\Request;
use App\DataTables\CropDataTable;
use DB;

class CropsController extends Controller
{
    // Get all crops...
    public function getCrops() {
         return DB::table('crops')
        ->select([
            'crops.id AS id',
            'crops.name AS text',
        ])->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CropDataTable $dataTable)
    {
        return $dataTable->render('crops.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'nullable',
            'minimum_production' => 'required'
        ]);

        Crop::create([
            'name' => request('name'),
            'description' => request('description'),
            'minimum_production' => request('minimum_production')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Crop  $crop
     * @return \Illuminate\Http\Response
     */
    public function edit(Crop $crop)
    {
        return view('crops.edit', compact('crop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Crop  $crop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Crop $crop)
    {
        $this->validate($request, [
            'name_edit' => 'required|max:255',
            'description_edit' => 'nullable',
            'minimum_production_edit' => 'required'
        ]);

        $crop->update([
            'name' => request('name_edit'),
            'description' => request('description_edit'),
            'minimum_production' => request('minimum_production_edit')
        ]);
    }
}
