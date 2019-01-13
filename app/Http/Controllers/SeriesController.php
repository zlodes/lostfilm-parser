<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController
{
    public function index(Request $request)
    {
        $query = $request->get('q');

        // TODO: filter and set current page
        $series = Series::query()->paginate(10);

        return view('index')->with([
            'series' => $series,
            'query' => $query ?: '',
        ]);
    }
}