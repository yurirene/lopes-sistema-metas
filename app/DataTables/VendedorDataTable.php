<?php

namespace App\DataTables;

use App\Models\Supervisor;
use App\Models\Vendedor;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VendedorDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($sql) {
                return view('supervisor.actions', [
                    'route' => 'supervisor',
                    'id' => $sql->id,
                ]);
            })
            ->editColumn('created_at', function ($sql) {
                return $sql->created_at->format('d/m/Y H:i:s');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Vendedor $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Vendedor $model)
    {
        $supervisor = Supervisor::first();
        return $model->newQuery()->when(!is_null($supervisor), function ($sql) use ($supervisor) {
            return $sql->where('supervisor_id', $supervisor->id);
        });
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('vendedor-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->parameters([
                'buttons' => [
                    [
                        'text' => '<i class="bi bi-person-plus"></i> Novo Vendedor',
                        'className' => 'btn-novo-registro',
                        'action' => 'function() {}'
                    ]
                ]
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
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('nome')->title('Nome'),
            Column::make('codigo')->title('Cod Supervisor'),
            Column::make('created_at')->title('Criado em'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Supervisores_' . date('YmdHis');
    }
}
