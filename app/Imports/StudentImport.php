<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (isset($row['ma_sinh_vien']) && isset($row['ho_lot']) && isset($row['ten']) && isset($row['ma_lop']) && isset($row['email']) && isset($row['ngay_sinh'])) {
            return Student::firstOrCreate(
                ['id' => $row['ma_sinh_vien']],
                [
                    'fullname' => trim($row['ho_lot']) . ' ' . trim($row['ten']),
                    'classname' => $row['ma_lop'],
                    'email' => $row['email'],
                    'birth' => $row['ngay_sinh'],
                ]
            );
        }

        return null;
    }
}
