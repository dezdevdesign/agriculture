<?php

namespace App\Http\Controllers;

use App\Farmer;
use Illuminate\Http\Request;
use App\DataTables\FarmerDataTable;
use DB;

class FarmersController extends Controller
{
    // Get all crops...
    public function getFarmers() {
         return DB::table('farmers')
        ->select([
            'farmers.id AS id',
            'farmers.name AS text',
        ])->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FarmerDataTable $dataTable)
    {
        return $dataTable->render('farmers.index');
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
            'name' => 'required|string|max:255',
            'age' => 'nullable',
            'address' => 'required',
            'contact' => 'required',
        ]);

        Farmer::create([
            'name' => request('name'),
            'age' => request('age'),
            'address' => request('address'),
            'contact' => request('contact')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function edit(Farmer $farmer)
    {
        return view('farmers.edit', compact('farmer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Farmer $farmer)
    {
        $this->validate($request, [
            'name_edit' => 'required|string|max:255',
            'age_edit' => 'nullable',
            'address_edit' => 'required',
            'contact_edit' => 'required',
        ]);

        $farmer->update([
            'name' => request('name_edit'),
            'age' => request('age_edit'),
            'address' => request('address_edit'),
            'contact' => request('contact_edit')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Farmer $farmer)
    {
        //
    }
}
