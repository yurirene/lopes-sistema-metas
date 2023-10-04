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
     * Booleano se é Gerente
     *
     * @var string
     */
    protected $isGerente;

    public function __construct()
    {
        $this->isGerente = auth()->user()->perfil->name == 'gerente';
    }

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
            ->addColumn('referencia', function ($sql) {
                return $sql->planilha->referencia;
            })
            ->editColumn('meta_valor', function ($sql) {
                return $this->isGerente
                    ? $sql->meta_valor_formatado
                    : "<a class=''
                        data-bs-toggle='modal'
                        href='#atualizarModal'
                        data-id='$sql->id'
                        data-valor='$sql->meta_valor_formatado'
                        role='button'
                    >$sql->valor_meta</a>";
            })
            ->editColumn('nova_meta', function ($sql) {
                return !$this->isGerente
                    ? $sql->nova_meta
                    : "<a class=''
                        data-bs-toggle='modal'
                        href='#definirModal'
                        data-id='$sql->id'
                        data-valor='$sql->nova_meta'
                        role='button'
                    >$sql->nova_meta</a>";
            })
            ->rawColumns(['checkbox', 'status', 'meta_valor', 'nova_meta'])
            ->with('totalizadores', $this->totalizadores());
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PlanilhaItem $model)
    {
        $perfil = auth()->user()->perfil->name;
        return $model->newQuery()
            ->where('planilha_id', request()->route('planilha'))
            ->when(request()->filled('supervisores'), function ($sql) {
                return $sql->whereIn('cod_supervisor', request()->get('supervisores'));
            })
            ->when(request()->filled('empresa'), function ($sql) {
                return $sql->where('empresa', request()->get('empresa'));
            })
            ->when($perfil == 'supervisor', function ($sql) {
                $codigoSupervisor = auth()->user()->supervisor->codigo;
                return $sql->where('cod_supervisor', $codigoSupervisor);
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
                            "url" => "/vendor/datatables/Portuguese-Brasil.json"
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
        // $colunas = [];
        // if (!PermissaoService::verificaPermissao('permite_apagar_item_planilha')) {
        //     $colunas[] = Column::computed('action')
        //         ->exportable(false)
        //         ->printable(false)
        //         ->width(60)
        //         ->addClass('text-center')
        //         ->title('Ações');
        // }
        $colunas = [
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

        if ($this->isGerente) {
            $colunas = [
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
                Column::make('cob_meta')->title('Cob Meta'),
                Column::make('supervisor')->title('Supervisor'),
                Column::make('status')->title('Status'),
            ];
        }

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

    public function totalizadores()
    {
        $dados = $this->query((new PlanilhaItem()))->get();
        $totalizador['empresa'] = 0;
        $totalizador['cob_meta'] = 0;

        foreach ($dados as $dado) {
            $totalizador['cob_meta'] = $totalizador['cob_meta'] + $dado->cob_meta_numerico;
            $totalizador['empresa'] = $totalizador['empresa'] + $dado->meta_valor_numerico;
        }
        $totalizador['empresa'] = number_format($totalizador['empresa'], 2, ',', '.');
        $totalizador['cob_meta'] = number_format($totalizador['cob_meta'], 2, ',', '.');

        return $totalizador;
    }

}
