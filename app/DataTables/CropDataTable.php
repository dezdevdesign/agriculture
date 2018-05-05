<?php

namespace App\DataTables;

use App\Crop;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\QueryDataTable;
use DB;

class CropDataTable extends DataTable
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
        return $dataTable->addColumn('action', function ($crops) {
            return '<button id="crop-edit" value="'.$crops->id.'" type="button" class="btn btn-success btn-sm waves-effect"><i class="zmdi zmdi-edit"></i></button>';
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Crop $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Crop $model)
    {
        return DB::table('crops')
        ->select([
            'crops.id',
            'crops.name',
            'crops.description',
            'crops.minimum_production'
        ]);
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
        ->minifiedAjax()
        ->addAction(['width' => '80px'])
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
                    ['extend' => 'excelHtml5', 'title' => 'Crop List'],
                    ['extend' => 'csvHtml5', 'title' => 'Crop List'],
                    ['extend' => 'print', 'title' => 'Crop List'],
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
            ['data' => 'id', 'name' => 'crops.id', 'visible' => false, 'title' => 'ID #'], 
            ['data' => 'name', 'name' => 'crops.name', 'title' => 'Crop'],
            ['data' => 'description', 'name' => 'crops.description', 'title' => 'Description'],
            ['data' => 'minimum_production', 'name' => 'crops.minimum_production', 'title' => 'Minimum Production']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'crop_' . time();
    }
}
