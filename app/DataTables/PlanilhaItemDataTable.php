<?php

namespace App\DataTables;

use App\Models\PlanilhaItem;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PlanilhaItemDataTable extends DataTable
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
                return view('planilha.actions-item', [
                    'route' => 'planilha',
                    'id' => $sql->id,
                ]);
            })
            ->editColumn('created_at', function ($sql) {
                return $sql->created_at->format('d/m/Y H:i:s');
            })
            ->editColumn('status', function ($sql) {
                return $sql->status_formatado;
            })
            ->editColumn('meta_valor', function ($sql) {
                return "<a class=''
                    data-bs-toggle='modal'
                    href='#atualizarModal'
                    data-id='$sql->id'
                    data-valor='$sql->meta_valor'
                    role='button'
                >$sql->meta_valor</a>";
            })
            ->rawColumns(['status', 'meta_valor']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PlanilhaItem $model)
    {
        return $model->newQuery()
            ->where('planilha_id', request()->route('planilha'));
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('planilha-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->parameters([
                        'buttons' => []
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
            Column::make('data')->title('Data'),
            Column::make('cod_representante')->title('Representante'),
            Column::make('meta_valor')->title('Meta'),
            Column::make('status')->title('Status'),
            Column::make('subgrupo_produto')->title('Subgrupo Produto'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Metas_' . date('YmdHis');
    }
}
