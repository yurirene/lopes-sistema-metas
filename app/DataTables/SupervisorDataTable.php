<?php

namespace App\DataTables;

use App\Models\Planilha;
use App\Models\Supervisor;
use App\Models\User;
use App\Models\Users;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SupervisorDataTable extends DataTable
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
            })
            ->editColumn('email', function ($sql) {
                return $sql->usuario ? $sql->usuario->email : 'Sem registro';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Supervisor $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Supervisor $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('supervisor-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->parameters([
                'buttons' => [
                    [
                        'text' => '<i class="bi bi-person-plus"></i> Novo Supervisor',
                        'className' => 'btn-novo-registro',
                        'extend' => 'create'
                    ]
                ],
                "language" => [
                    "url" => "/vendor/datatables/Portuguese-Brasil.json"
                ],
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
                  ->addClass('text-center')
                  ->title('Ações'),
            Column::make('nome')->title('Nome'),
            Column::make('codigo')->title('Cod Supervisor'),
            Column::make('email')->title('E-mail'),
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
