<?php

namespace App\Exports;

use App\Models\Gestion;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromQuery, WithHeadings, WithColumnWidths, WithMapping, WithStyles
{
    
    use Exportable;
    protected $gestiones;

    public function __construct($gestiones)
    {
        $this->gestiones = $gestiones;
    }

    public function map($gestiones): array
    {
        return [

            $gestiones->deligencia->cliente->rut,
            $gestiones->deligencia->tribunal,
            $gestiones->deligencia->rol,
            $gestiones->deligencia->caratulado,
            $gestiones->f_notificacion,
            $gestiones->encargo,
            $gestiones->recibo->total,
            $gestiones->recibo->boleta,
            
            /*$gestiones->f_notificacion,
            $gestiones->resultado,
            $gestiones->deligencia->materia, 
            $gestiones->deligencia->obs,
            $gestiones->deligencia->cliente->name,
            $gestiones->deligencia->abogado->name,*/
            
        ];
    }

    public function headings(): array
    {
        return 

        [
        [
            'Formulario Rendición Gastos Judiciales ADG ABOGADOS'
        ],
        [
            '',
            'Nombre del Proveedor:  SARA ESMERALDA DEL ROSARIO CUELLAR ZAMORA',
            '',
            'Rut del Proveedor:   9.043.499-3',
        ],
        [
            '',
            'Banco de depósito:',
            '',
            'Tipo de cuenta:',
            'N° Cuenta:',
        ],
        [
            'RUT', 
            'TRIBUNAL',
            'ROL',
            'CARATULADO',
            'FECHA EJECUCIÓN',
            'RESULTADO GESTIÓN',
            'VALOR GESTION',
            'N° RECIBO'
        ]
        ];
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function columnWidths(): array
    {
    
        return [
            'A' => 13,
            'B' => 35,
            'C' => 12,
            'D' => 40, 
            'E' => 12, 
            'F' => 30, 
            'G' => 12, 
            'H' => 13,

        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
            4    => ['font' => ['bold' => true]],
            1    => ['font' => ['size' => 20]], 
            //$sheet->mergeCells('A1:H1'),
        ];
    }

    public function query()
    {
        return Gestion::query()->whereKey($this->gestiones)->with('deligencia.cliente','deligencia.abogado','deligencia.demandado');
    }
}
