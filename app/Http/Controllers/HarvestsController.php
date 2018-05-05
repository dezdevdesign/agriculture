<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use DB;

class HarvestsController extends Controller
{
    public function getHarvests(Request $request) {
        $harvests = DB::table('harvests')
        ->join('croppings', 'croppings.harvest_id', '=', 'harvests.id')
        ->join('farmers', 'farmers.id', '=', 'croppings.farmer_id')
        ->join('crops', 'crops.id', '=', 'croppings.crop_id')
        ->join('maps', 'maps.id', '=', 'croppings.map_id')
        ->select([
            'harvests.id',
            'crops.name AS crop',
            'croppings.date_start',
            'croppings.date_end',
            'croppings.season',
            'harvests.harvested',
            'harvests.production',
            'harvests.yield',
            'harvests.status',
            'harvests.reason',
            'harvests.climate',
            'harvests.fertilizer',
            'harvests.remarks',
            'farmers.name AS farmer'
        ]);

        if($request->has('map_id')) {
            $harvests->where('croppings.map_id', '=', request('map_id'));
        }

        return DataTables::of($harvests)
        ->addColumn('action', function($harvests) {
            return '<button>Test</button>';
        })->editColumn('date_start', function($harvests) {
            return $harvests->date_start ? with(new Carbon($harvests->date_start))->format('M Y') : '';
        })->editColumn('date_end', function($harvests) {
            return $harvests->date_end ? with(new Carbon($harvests->date_end))->format('M Y') : '';
        })->make(true);
    }
}
