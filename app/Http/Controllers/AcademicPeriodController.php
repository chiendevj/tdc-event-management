<?php

namespace App\Http\Controllers;

use App\Models\AcademicPeriod;
use Illuminate\Http\Request;

class AcademicPeriodController extends Controller
{
    public function getAcademicPeriods()
    {
        $academicPeriods = AcademicPeriod::all();
        return response()->json(["data" => $academicPeriods, "message" => "Get Academic Periods success !!!", "status" => "success"]);
    }
}
