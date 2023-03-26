<?php

namespace App\DataTables;

use App\Models\PlanilhaItem;
use App\Services\PermissaoService;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AlteracaoMetasDataTable extends DataTable
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
            ->editColumn('checkbox', function ($query) {
                return "<input type='checkbox'
                    class='form-check-input isCheck form-checkbox'
                    name='linhas'
                    id='checkbox_$query->id'
                    value='$query->id'>";
            })
            ->editColumn('created_at', function ($sql) {
                return $sql->created_at->format('d/m/Y H:i:s');
            })
            ->addColumn('referencia', function ($sql) {
                return $sql->planilha->referencia;
            })
            ->editColumn('meta_valor', function ($sql) {
                return $sql->meta_valor_formatado;
            })
            ->rawColumns(['meta_valor', 'checkbox']);
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
            ->where('status', PlanilhaItem::AGUARDANDO)
            ->when(request()->filled('supervisores'), function ($sql) {
                return $sql->whereIn('cod_supervisor', request()->get('supervisores'));
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
                    ->setTableId('atualizar-metas-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->pageLength(100)
                    ->orderBy(1)
                    ->parameters([
                        'buttons' => [],
                        "language" => [
                            "url" => "//cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json"
                        ],
                        'responsive' => true
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
            Column::make('checkbox')
                ->title('<input type="checkbox"  id="checkbox-master" />')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->searchable(false),
            Column::make('referencia')->title('Referência'),
            Column::make('subgrupo_produto')->title('Subgrupo Produto'),
            Column::make('produto')->title('Produto'),
            Column::make('representante')->title('Representante'),
            Column::make('meta_valor')->title('Meta Valor'),
            Column::make('nova_meta')->title('Novo Valor'),
            Column::make('supervisor')->title('Supervisor'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'MetasPendentes_' . date('YmdHis');
    }
}
