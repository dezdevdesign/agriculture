<?php

namespace App\Http\Controllers;

use App\Cropping;
use App\Harvest;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use App\DataTables\CroppingDataTable;
use App\DataTables\HarvestDataTable;
use DB;

class CroppingsController extends Controller
{
    public function getCroppings(Request $request) {
        $croppings = DB::table('croppings')
        ->join('farmers', 'farmers.id', '=', 'croppings.farmer_id')
        ->join('crops', 'crops.id', '=', 'croppings.crop_id')
        ->join('maps', 'maps.id', '=', 'croppings.map_id')
        ->select([
            'croppings.id',
            'crops.name AS crop',
            'croppings.date_start',
            'croppings.date_end',
            'croppings.season',
            'croppings.process',
            'farmers.name AS farmer',
        ]);

        if($request->has('map_id')) {
            $croppings->where('croppings.map_id', '=', request('map_id'));
        }

        return DataTables::of($croppings)
        ->addColumn('action', function($croppings) {
            return '<button>Test</button>';
        })->editColumn('date_start', function($croppings) {
            return $croppings->date_start ? with(new Carbon($croppings->date_start))->format('M Y') : '';
        })->editColumn('date_end', function($croppings) {
            return $croppings->date_end ? with(new Carbon($croppings->date_end))->format('M Y') : '';
        })->make(true);
    }

    public function index()
    {
        return view('croppings.index');
    }

    public function list(CroppingDataTable $dataTable) {
        return $dataTable->render('croppings.list');
    }

    public function harvests(HarvestDataTable $dataTable) {
        return $dataTable->render('croppings.harvests');
    }

    public function store(Request $request)
    {
        $harvest_id = null;
        // Cropping validations...
        $this->validate($request, [
            'date_start' => 'required',
            'date_end' => 'required',
            'season' => 'required',
            'process' => 'required',
            'crop_id' => 'required|exists:crops,id',
            'farmer_id' => 'required|exists:farmers,id',
            'map_id' => 'required|exists:maps,id',
            'harvest_id' => 'nullable'
        ]);

        if(request('process') == 'Harvesting') {
            // Harvest validations...
            $this->validate($request, [
                'harvested' => 'required',
                'production' => 'required',
                'yield' => 'required',
                'status' => 'required',
                'reason' => 'nullable',
                'climate' => 'required',
                'fertilizer' => 'required',
                'remarks' => 'nullable'
            ]);

            // Create harvest...
            $harvest = Harvest::create([
                'harvested' => request('harvested'),
                'production' => request('production'),
                'yield' => request('yield'),
                'status' => request('status'),
                'reason' => request('reason'),
                'climate' => request('climate'),
                'fertilizer' => request('fertilizer'),
                'remarks' => request('remarks')
            ]);

            $harvest_id = $harvest->id;
        }

        // Create cropping....
        Cropping::create([
            'date_start' => request('date_start') . '-01',
            'date_end' => request('date_end') . '-01',
            'season' => request('season'),
            'process' => request('process'),
            'crop_id' => request('crop_id'),
            'farmer_id' => request('farmer_id'),
            'map_id' => request('map_id'),
            'harvest_id' => $harvest_id
        ]);
    }

    public function update(Request $request, Cropping $cropping)
    {
        //
    }
}
