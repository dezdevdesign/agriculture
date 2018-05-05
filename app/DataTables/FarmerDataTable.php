<?php

namespace App\DataTables;

use App\Farmer;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\QueryDataTable;
use DB;

class FarmerDataTable extends DataTable
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
        return $dataTable->addColumn('action', function ($farmers) {
            return '<button id="farmer-edit" value="'.$farmers->id.'" type="button" class="btn btn-success btn-sm waves-effect"><i class="zmdi zmdi-edit"></i></button>';
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Farmer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Farmer $model)
    {
        return DB::table('farmers')
        ->select([
            'farmers.id',
            'farmers.name',
            'farmers.age',
            'farmers.address',
            'farmers.contact'
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
                    ['extend' => 'excelHtml5', 'title' => 'Farmer List'],
                    ['extend' => 'csvHtml5', 'title' => 'Farmer List'],
                    ['extend' => 'print', 'title' => 'Farmer List'],
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
            ['data' => 'id', 'name' => 'farmers.id', 'title' => 'ID #'], 
            ['data' => 'name', 'name' => 'farmers.name', 'title' => 'Name'],
            ['data' => 'age', 'name' => 'farmers.age', 'title' => 'Age'],
            ['data' => 'address', 'name' => 'farmers.address', 'title' => 'Address'],
            ['data' => 'contact', 'name' => 'farmers.contact', 'title' => 'Contact'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'farmer_' . time();
    }
}
