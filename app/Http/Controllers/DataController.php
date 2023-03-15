<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController
{
    public function store(Request $request)
    {
        dd($request->all());
    }
}
