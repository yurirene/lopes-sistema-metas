<?php

namespace App\DataTables;

use App\Models\Planilha;
use App\Models\User;
use App\Models\Users;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PlanilhaDataTable extends DataTable
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
                return view('planilha.actions', [
                    'route' => 'planilha',
                    'id' => $sql->id,
                ]);
            })
            ->editColumn('created_at', function ($sql) {
                return $sql->created_at->format('d/m/Y H:i:s');
            })
            ->editColumn('user_id', function ($sql) {
                return $sql->usuario->name;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Planilha $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Planilha $model)
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
        $html = $this->builder()
            ->setTableId('planilha-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->parameters([
                "buttons" => [],
                "language" => [
                    "url" => "/vendor/datatables/Portuguese-Brasil.json"
                ],
            ]);
        if (auth()->user()->perfil->name == 'analista') {
            $html = $html->buttons(
                Button::make('create')
                    ->text('<i class="bi bi-file-earmark-arrow-up"></i> Importar')
                    ->addClass('btn-novo-registro')
                    ->action("function() {
                        $('#importar').modal('show');
                }")
            );
        }
        return $html;
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
            Column::make('referencia')->title('Referencia'),
            Column::make('user_id')->title('Usuário'),
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
        return 'Users_' . date('YmdHis');
    }
}
