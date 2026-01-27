<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserVillageExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    private $rowNumber = 0;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::whereHas('userHasVillages')
            ->with('userHasVillages.village.district')
            ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Kecamatan',
            'Nama',
            'Email',
            'Password',
        ];
    }

    /**
     * @param User $user
     * @return array
     */
    public function map($user): array
    {
        $districts = $user->userHasVillages->map(function ($userVillage) {
            return $userVillage->village->district->name ?? '-';
        })->unique()->join(', ');

        return [
            ++$this->rowNumber,
            $districts ?: '-',
            $user->name,
            $user->email,
            '1234567890',
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
