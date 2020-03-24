<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StatsController extends Controller
{
    /**
     * @param Request $request
     *
     * @param Country $country
     * @param string $level
     *
     * @return JsonResponse
     */
    public function index(Request $request, Country $country, $level = 'region')
    {
        $source = $country->source->get($level);
        $mapping = $country->mapping->get($level);
        $data = Http::get($source)->json();

        if ($mapping) {
            $data = collect($data)->map(function ($d) use ($mapping) {
                $row = [];
                collect($mapping)->each(function ($destination, $source) use (&$row, $d) {
                    $row[$destination] = $d[$source] ?? '';
                });
                return $row;
            });
        }

        return response()->json($data);
    }

    public function web(Request $request, Country $country)
    {
        $source =$country->source->get('tracking');
        $mapping = $country->mapping->get('tracking');
        $data = Http::get($source)->json();

        if ($mapping) {
            $data = collect($data)->map(function ($d) use ($mapping) {
                $row = [];
                collect($mapping)->each(function ($destination, $source) use (&$row, $d) {
                    $row[$destination] = $d[$source] ?? '';
                });
                return $row;
            });
        }
        return view('welcome', ['data' => $data->sortByDesc('date'),'keys'=>array_keys($data->first())]);
    }

}
