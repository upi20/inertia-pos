<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LabController extends Controller
{
    public function arr(Request $request)
    {
        return response()->json(['status' => true, 'request' => $request->nama]);
    }
}
