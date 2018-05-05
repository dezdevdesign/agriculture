<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cropping;
use App\Harvest;
use App\Map;
use App\DataTables\BetaDataTable;
use DB;

class HomeController extends Controller
{
    public function getYearlyYield() {
        $query = DB::table('harvests')
        ->leftJoin('croppings', 'croppings.harvest_id', '=', 'harvests.id')
        ->leftJoin('maps', 'croppings.map_id', '=', 'maps.id')
        ->select([
            DB::raw("YEAR(croppings.date_end) AS year"),
            DB::raw("SUM(harvests.yield) AS total_yield"),
        ])
        ->groupBy(DB::raw("YEAR(croppings.date_end)"))
        ->where('croppings.crop_id', request('crop'));

        if(request('from') != null || request('from') != '' && request('to') != null || request('to') != '') {
            $query->whereBetween(DB::raw("YEAR(croppings.date_end)"), [request('from'), request('to')]);
        }

        if(request('municipality') !== null || request('municipality') != '') {
            $query->where('maps.municipality', request('municipality'));
        }
        return $query->get();
    }

    public function getMonthlyYield() {
        $query = DB::table('harvests')
        ->leftJoin('croppings', 'croppings.harvest_id', '=', 'harvests.id')
        ->leftJoin('maps', 'croppings.map_id', '=', 'maps.id')
        ->select([
            DB::raw("MONTH(croppings.date_end) AS month"),
            DB::raw("MONTHNAME(croppings.date_end) AS monthname"),
            DB::raw("SUM(harvests.yield) AS total_yield"),
        ])
        ->groupBy(DB::raw("MONTH(croppings.date_end)"))
        ->groupBy(DB::raw("MONTHNAME(croppings.date_end)"))
        ->where('croppings.crop_id', request('crop'));

        if(request('from') != null || request('from') != '') {
            $query->whereYear('croppings.date_end', request('from'));
        }

        if(request('municipality') !== null || request('municipality') != '') {
            $query->where('maps.municipality', request('municipality'));
        }

        return $query->get();
    }

    public function getWateringChart() {
        $query = DB::table('harvests')
        ->leftJoin('croppings', 'croppings.harvest_id', '=', 'harvests.id')
        ->leftJoin('maps', 'croppings.map_id', '=' ,'maps.id')
        ->select([
            DB::raw('COUNT(maps.id) AS count'),
            'maps.watering_type AS type',
        ])
        ->groupBy('watering_type')
        ->where('harvests.status', 'Good');

        if(request('municipality') != null) {
            $query->where('maps.municipality', request('municipality'));
        }

        if(request('barangay') != null) {
            $query->whereYear('maps.barangay', request('barangay'));
        }

        return $query->get();
    }

    public function getSoilTypeChart() {
        $query = DB::table('harvests')
        ->leftJoin('croppings', 'croppings.harvest_id', '=', 'harvests.id')
        ->leftJoin('maps', 'croppings.map_id', '=' ,'maps.id')
        ->select([
            DB::raw('COUNT(maps.id) AS count'),
            'maps.soil_type AS type',
        ])
        ->groupBy('soil_type')
        ->where('harvests.status', 'Good');

        if(request('municipality') != null) {
            $query->where('maps.municipality', request('municipality'));
        }

        if(request('barangay') != null) {
            $query->whereYear('maps.barangay', request('barangay'));
        }

        return $query->get();
    }

    public function getBadReasonChart() {
        $query = DB::table('harvests')
        ->leftJoin('croppings', 'croppings.harvest_id', '=', 'harvests.id')
        ->leftJoin('maps', 'croppings.map_id', '=' ,'maps.id')
        ->select([
            DB::raw('COUNT(maps.id) AS count'),
            'harvests.reason AS reason',
        ])
        ->where('status', 'Bad')
        ->groupBy('reason');

        if(request('municipality') != null) {
            $query->where('maps.municipality', request('municipality'));
        }

        if(request('barangay') != null) {
            $query->whereYear('maps.barangay', request('barangay'));
        }

        return $query->get();
    }

    public function getHarvestChart() {
        $query = DB::table('harvests')
        ->leftJoin('croppings', 'croppings.harvest_id', '=', 'harvests.id')
        ->leftJoin('crops', 'croppings.crop_id', '=', 'crops.id')
        ->select([
            DB::raw('SUM(harvests.harvested) AS harvest'),
            DB::raw('SUM(harvests.production) AS production'),
            DB::raw('SUM(harvests.yield) AS yield'),
            'croppings.season'
        ])
        ->groupBy('croppings.season');

        if(request('crop_id') != null) {
            $query->where('crops.id', request('crop_id'));
        }

        if(request('year') != null) {
            $query->whereYear('croppings.date_end', request('year'));
        }

        return $query->get();
    }

    public function getHarvested() {
        $harvested = DB::table('harvests')
        ->leftJoin('croppings', 'croppings.harvest_id', '=', 'harvests.id')
        ->leftJoin('crops', 'croppings.crop_id', '=', 'crops.id');

        if(request('crop_id') != null) {
            $harvested->where('crops.id', request('crop_id'));
        }

        if(request('year') != null) {
            $harvested->whereYear('croppings.date_end', request('year'));
        }

        return $harvested->sum('harvested');
    }

    public function getProduction() {
        $production = DB::table('harvests')
        ->leftJoin('croppings', 'croppings.harvest_id', '=', 'harvests.id')
        ->leftJoin('crops', 'croppings.crop_id', '=', 'crops.id')
        ->select([
            DB::raw('SUM(harvests.production) AS production'),
            'crops.minimum_production'
        ]);

        if(request('crop_id') != null) {
            $production->where('crops.id', request('crop_id'));
        }

        if(request('year') != null) {
            $production->whereYear('croppings.date_end', request('year'));
        }

        return $production->groupBy('crops.id')->get();
    }

    public function getYield() {
        $yield = DB::table('harvests')
        ->leftJoin('croppings', 'croppings.harvest_id', '=', 'harvests.id')
        ->leftJoin('crops', 'croppings.crop_id', '=', 'crops.id');

        if(request('crop_id') != null) {
            $yield->where('crops.id', request('crop_id'));
        }

        if(request('year') != null) {
            $yield->whereYear('croppings.date_end', request('year'));
        }

        return $yield->sum('yield');
    }

    public function checkCause() {
        $harvested = DB::table('harvests')
        ->leftJoin('croppings', 'croppings.harvest_id', '=', 'harvests.id')
        ->leftJoin('crops', 'croppings.crop_id', '=', 'crops.id')
        ->select([
            'harvests.status',
            'harvests.remarks'
        ]);

        if(request('crop_id') != null) {
             $harvested->where('crops.id', request('crop_id'));
        }

        if(request('year') != null) {
            $harvested->whereYear('croppings.date_end', request('year'));
        }

        return $harvested->get();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maps = Map::all();

        $harvested = DB::table('harvests')->sum('harvested');
        $yield = DB::table('harvests')->sum('yield');
        
        return view('home', compact('maps'));
    }
}
