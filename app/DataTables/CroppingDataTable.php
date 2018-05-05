<?php

namespace App\DataTables;

use App\Cropping;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\QueryDataTable;
use Carbon\Carbon;
use DB;

class CroppingDataTable extends DataTable
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

        $dataTable->addColumn('action', function ($cropping) {
            return '<button id="cropping-edit" value="'.$cropping->id.'" type="button" class="btn btn-success btn-sm waves-effect"><i class="zmdi zmdi-edit"></i></button>';
        })->editColumn('date_start', function($croppings) {
            return $croppings->date_start ? with(new Carbon($croppings->date_start))->format('M Y') : '';
        })->editColumn('date_end', function($croppings) {
            return $croppings->date_end ? with(new Carbon($croppings->date_end))->format('M Y') : '';
        });
        
        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Cropping $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Cropping $model)
    {
        $query = DB::table('croppings')
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
            ['data' => 'id', 'name' => 'croppings.id', 'visible' => false, 'title' => 'ID #'],
            ['data' => 'crop', 'name' => 'crops.name', 'title' => 'Crop'], 
            ['data' => 'date_start', 'name' => 'croppings.date_start', 'title' => 'Date Start'],
            ['data' => 'date_end', 'name' => 'croppings.date_end', 'title' => 'Date End'],
            ['data' => 'season', 'name' => 'croppings.season', 'title' => 'Season'],
            ['data' => 'process', 'name' => 'croppings.process', 'title' => 'Process'],
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
        return 'Cropping_' . date('YmdHis');
    }
}
