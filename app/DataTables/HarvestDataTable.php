<?php

namespace App\DataTables;

use App\Harvest;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\QueryDataTable;
use Carbon\Carbon;
use DB;

class HarvestDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new QueryDataTable($query);

        $dataTable->addColumn('action', function ($harvests) {
            return '<button id="harvest-edit" value="'.$harvests->id.'" type="button" class="btn btn-success btn-sm waves-effect"><i class="zmdi zmdi-edit"></i></button>';
        })->editColumn('date_start', function($harvests) {
            return $harvests->date_start ? with(new Carbon($harvests->date_start))->format('M Y') : '';
        })->editColumn('date_end', function($harvests) {
            return $harvests->date_end ? with(new Carbon($harvests->date_end))->format('M Y') : '';
        });
        
        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Harvest $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Harvest $model)
    {
        $query = DB::table('harvests')
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
            'harvests.remarks',
            'farmers.name AS farmer'
        ]);

        if(request('municipality') != null && request('barangay') != null) {
            $query->where('maps.barangay', '=', request('barangay'));
        }else if(request('municipality') != null) {
            $query->where('maps.municipality', '=', request('municipality'));
        }

        if(request('crop') != null) {
            $query->where('crops.id', '=', request('crop'));
        }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
        ->columns($this->getColumns())
         ->ajax([
            'type' => 'GET',
            'data' => 'function(d) { d.municipality = $("#municipality").val(), d.barangay = $("#barangay").val(), d.crop = $("#crop").val();}'
        ]) 
        // ->addAction(['width' => '80px'])
        ->parameters([
            'autoWidth' => true,
            'responsive' => true,
            'lengthMenu' => 
                [
                    [15, 30, 45, -1], 
                    ['15 Rows', '30 Rows', '45 Rows', 'Everything']
                ],
            'dom' => 'Blfrtip',
            'buttons' => 
                [
                    ['extend' => 'excelHtml5'],
                    ['extend' => 'csvHtml5'],
                    ['extend' => 'print'],
                ],
            'initComplete' => 'function(settings, json) {
                $(this).closest(".dataTables_wrapper").prepend(dataTableButtons);
            }'
        ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['data' => 'id', 'name' => 'harvests.id', 'visible' => false, 'title' => 'ID #'],
            ['data' => 'crop', 'name' => 'crops.name', 'title' => 'Crop'], 
            ['data' => 'date_start', 'name' => 'croppings.date_start', 'title' => 'Date Start'],
            ['data' => 'date_end', 'name' => 'croppings.date_end', 'title' => 'Date End'],
            ['data' => 'season', 'name' => 'croppings.season', 'title' => 'Season'],
            ['data' => 'harvested', 'name' => 'harvests.harvested', 'title' => 'Harvested'],
            ['data' => 'production', 'name' => 'harvests.production', 'title' => 'Production'],
            ['data' => 'yield', 'name' => 'harvests.yield', 'title' => 'Yield'],
            ['data' => 'status', 'name' => 'harvests.status', 'title' => 'Status'],
            ['data' => 'reason', 'name' => 'harvests.reason', 'title' => 'Reason'],
            ['data' => 'remarks', 'name' => 'harvests.remarks', 'title' => 'Remarks'],
            ['data' => 'farmer', 'name' => 'farmers.name', 'title' => 'Farmer'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Harvest_' . date('YmdHis');
    }
}
