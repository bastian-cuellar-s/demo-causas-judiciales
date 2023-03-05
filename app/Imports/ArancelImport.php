<?php

namespace App\Imports;

use App\Models\Arancel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ArancelImport implements 

ToModel,
WithHeadingRow,
SkipsOnError,
SkipsOnFailure,
WithChunkReading,
ShouldQueue,
WithEvents

{

    use Importable, SkipsErrors, SkipsFailures, RegistersEventListeners;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function  __construct($g_arancel_id)
    {
        $this->g_arancel_id= $g_arancel_id;
    }

    public function model(array $row)
    {
        $data = new Arancel([
            'name' => $row['name'],
            'valor' => $row['valor'],
            'g_arancel_id' => $this->g_arancel_id,
        ]);

        //array_push($this->arancel_data ,$data);
        
        //dd($this->arancel_data);

        return $data;
    }

    /*public function getRowCount(): array
    {
        return $this->arancel_data;
    }*/

    /*public function collection(Collection $rows)
    {
        
        foreach ($rows as $row) {
            $user = Arancel::create([
                'name' => $row['name'],
                'valor' => $row['valor'],
                'persona_id' => $this->persona_id,
            ]);
            array_push($this->arancel_data ,$user);
        }

        after

        return $this->arancel_data;
    }*/

    /*public function rules(): array
    {
        return [
            '*.email' => ['email', 'unique:users,email']
        ];
    }*/


    public function chunkSize(): int
    {
        return 1000;
    }

    public static function afterImport(AfterImport $event)
    {
        return $event;
    }

    public function onFailure(Failure ...$failure)
    {
    }
}
