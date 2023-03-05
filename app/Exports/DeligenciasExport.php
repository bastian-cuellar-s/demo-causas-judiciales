<?php

namespace App\Exports;

use App\Models\Deligencia;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;   


class DeligenciasExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    use Exportable;
    protected $deligencias;

    public function __construct($deligencias)
    {
        $this->deligencias = $deligencias;
    }

    public function map($deligencias): array
    {
        return [
            $deligencias->rol,
            $deligencias->tribunal,
            $deligencias->encargo,
            $deligencias->materia,
            $deligencias->f_deligencia,
            $deligencias->f_demanda,
            $deligencias->f_estampado,
            $deligencias->f_resolucion,
            $deligencias->obs,
            $deligencias->cliente->name,
            $deligencias->abogado->name,
            $deligencias->demandado->name,
        ];
    }

    public function headings(): array
    {
        return [
            'Rol', 
            'Tribunal', 
            'Detalle Deligencia',
            'Materia',
            'Fecha Diligencia',
            'Fecha Demanda',
            'Fecha Estampado',
            'Fecha Resolución',
            'Observaciones',
            'Cliente',
            'Abogado',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function query()
    {
        return Deligencia::query()->whereKey($this->deligencias)->with('cliente','abogado');
    }

    

}
