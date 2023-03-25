<?php

namespace App\DataTables;

use App\Models\PlanilhaItem;
use App\Services\PermissaoService;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PlanilhaItemDataTable extends DataTable
{
    protected $printColumns = [
        'data',
        'cod_gerente',
        'gerente',
        'familia_produto',
        'subgrupo_produto',
        'cod_produto',
        'produto',
        'cod_empresa',
        'empresa',
        'qtd_meta',
        'volume_meta_kg',
        'meta_valor',
        'cob_meta',
        'cod_subgrupo_produto',
        'tipo_subgrupo_produto',
        'cod_supervisor',
        'supervisor',
        'cod_representante',
        'representante',
        'status'
    ];

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
                    data-valor='$sql->meta_valor_formatado'
                    role='button'
                >$sql->valor_meta</a>";
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
            ->where('planilha_id', request()->route('planilha'))
            ->when(request()->filled('supervisores'), function ($sql) {
                return $sql->whereIn('cod_supervisor', request()->get('supervisores'));
            })
            ->when(request()->filled('status'), function ($sql) {
                return $sql->where('status', request()->get('status'));
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
                    ->setTableId('planilha-item-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('lBfrtip')
                    ->orderBy(1)
                    ->parameters([
                        'buttons' => [
                            [
                                'text' => '<em class="fas fa-file-excel"></em> Baixar CSV',
                                'extend' => 'csv'
                            ]
                        ],
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
        $colunas = [];
        if (!PermissaoService::verificaPermissao('permite_apagar_item_planilha')) {
            $colunas[] = Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center');
        }
        $colunas += [
            Column::make('data')->title('Data'),
            Column::make('cod_gerente')->title('Cod Gerente'),
            Column::make('gerente')->title('Gerente'),
            Column::make('familia_produto')->title('Familia Produto'),
            Column::make('subgrupo_produto')->title('Subgrupo Produto'),
            Column::make('cod_produto')->title('Cod Produto'),
            Column::make('produto')->title('Produto'),
            Column::make('cod_empresa')->title('Cod Empresa'),
            Column::make('empresa')->title('Empresa'),
            Column::make('qtd_meta')->title('Qtd Meta'),
            Column::make('volume_meta_kg')->title('Volume Meta Kg'),
            Column::make('meta_valor')->title('Meta Valor'),
            Column::make('cob_meta')->title('Cob Meta'),
            Column::make('cod_subgrupo_produto')->title('Cod Subgrupo Produto'),
            Column::make('tipo_subgrupo_produto')->title('Tipo Subgrupo Produto'),
            Column::make('cod_supervisor')->title('Cod Supervisor'),
            Column::make('supervisor')->title('Supervisor'),
            Column::make('cod_representante')->title('Cod Representante'),
            Column::make('representante')->title('Representante'),
            Column::make('status')->title('Status'),
        ];
        return $colunas;
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
