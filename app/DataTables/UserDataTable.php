<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\QueryDataTable;
use DB;

class UserDataTable extends DataTable
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
        return $dataTable->addColumn('action', function ($users) {
            return '<button id="user-edit" value="'.$users->id.'" type="button" class="btn btn-success btn-sm waves-effect"><i class="zmdi zmdi-edit"></i></button>';
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return DB::table('users')
        ->select([
            'users.id',
            'users.name',
            'users.username',
            'users.contact',
            'users.municipality',
            'users.position'
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
                    ['extend' => 'excelHtml5', 'title' => 'User List'],
                    ['extend' => 'csvHtml5', 'title' => 'User List'],
                    ['extend' => 'print', 'title' => 'User List'],
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
            ['data' => 'id', 'name' => 'users.id', 'visible' => false, 'title' => 'ID #'], 
            ['data' => 'name', 'name' => 'users.name', 'title' => 'Name'],
            ['data' => 'username', 'name' => 'users.username', 'title' => 'Username'],
            ['data' => 'contact', 'name' => 'users.contact', 'title' => 'Contact'],
            ['data' => 'municipality', 'name' => 'users.municipality', 'title' => 'Municipality'],
            ['data' => 'position', 'name' => 'users.position', 'title' => 'Position']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'user_' . time();
    }
}
