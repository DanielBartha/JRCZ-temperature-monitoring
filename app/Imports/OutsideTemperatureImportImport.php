<?php

namespace App\Imports;

use App\Models\Room;
use App\Models\outsideTemperatureImport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Http\Request;

class OutsideTemperatureImportImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row): \Illuminate\Database\Eloquent\Model|outsideTemperatureImport|null
    {
        return new outsideTemperatureImport([
            'time' => $this->convertToDateTime($row[0]),
            'outside_temperature' => $row[2]
        ]);
    }
    public function startRow(): int
    {
        return 3;
    }

    private function convertToDateTime($excelDate): string
    {
        return substr($excelDate, 0, 10) . ' ' . substr($excelDate, 11, 8);
    }
}
