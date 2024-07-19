<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImport;
use Illuminate\Support\Facades\Log;

class ExcelController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'import_students' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('import_students');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Tệp tin không hợp lệ hoặc bị lỗi.');
        }

        try {
            Excel::import(new StudentImport, $file);
            return redirect()->back()->with('success', 'Dữ liệu đã được nhập vào thành công!');
        } catch (\Throwable $e) {
            Log::error('Lỗi khi nhập dữ liệu: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi nhập dữ liệu: ' . $e->getMessage());
        }
    }
}
