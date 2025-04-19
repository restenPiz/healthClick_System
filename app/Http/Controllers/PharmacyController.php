<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    public function index()
    {
        $pharmacies = Pharmacy::with('user')->get();

        return response()->json([
            'status' => true,
            'pharmacies' => $pharmacies
        ]);
    }
}
