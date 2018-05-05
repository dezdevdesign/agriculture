<?php

namespace App\Http\Controllers;

use App\Map;
use Illuminate\Http\Request;
use DB;

class MapsController extends Controller
{
    public function getLotCenter(Request $request) {
        return DB::table('maps')
        ->select('maps.lot_lat', 'maps.lot_lng')
        ->where('id', request('lot_id'))
        ->get();
    }

    public function loadLotSelect() {
        return DB::table('maps')
        ->select('id', 'lot AS text')
        ->get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('maps.index');
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
            'lot' => 'required',
            'watering_type' => 'required',
            'soil_type' => 'required',
            'municipality' => 'required',
            'barangay' => 'required',
            'area' => 'required',
            'coordinates' => 'required',
            'lot_lat' => 'required',
            'lot_lng' => 'required'
        ]);

        Map::create([
            'lot' => request('lot'),
            'watering_type' => request('watering_type'),
            'soil_type' => request('soil_type'),
            'municipality' => request('municipality'),
            'barangay' => request('barangay'),
            'area' => request('area'),
            'coordinates' => request('coordinates'),
            'lot_lat' => request('lot_lat'),
            'lot_lng' => request('lot_lng')
        ]);
    }

    /**
     * Load all polygons saved in database.
     *
     * @param  \App\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function loadMaps(Map $map)
    {
        return DB::table('maps')
        ->join('cities', 'cities.id', '=', 'maps.municipality')
        ->join('barangays', 'barangays.id', '=', 'maps.barangay')
        ->select([
            'maps.*',
            'cities.text AS municipality_name',
            'barangays.text AS barangay_name'
        ])->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function edit(Map $map)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Map $map)
    {
        $this->validate($request, [
            'lot' => 'required',
            'watering_type' => 'required',
            'soil_type' => 'required',
            'municipality' => 'required',
            'barangay' => 'required',
            'coordinates' => 'required',
            'lot_lat' => 'required',
            'lot_lng' => 'required'
        ]);

        $map->update([
            'lot' => request('lot'),
            'watering_type' => request('watering_type'),
            'soil_type' => request('soil_type'),
            'municipality' => request('municipality'),
            'barangay' => request('barangay'),
            'coordinates' => request('coordinates'),
            'lot_lat' => request('lot_lat'),
            'lot_lng' => request('lot_lng')
        ]);
    }
}
