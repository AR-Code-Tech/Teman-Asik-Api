<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transportation;

class NavigationController extends Controller
{
    public function index(Request $request)
    {
        $data = [];

        // origin
        $origins = explode(',', $request->origin);
        $data['origin'] = [
            'lat' => floatval($origins[0]),
            'lng' => floatval($origins[1])
        ];

        // destination
        $destinations = explode(',', $request->destination);
        $data['destination'] = [
            'lat' => floatval($destinations[0]),
            'lng' => floatval($destinations[1]),
        ];

        // transporations
        // $transportations = Transportation::select('id', 'name', 'description')->get();
        // $transportations->load('routes');
        // $data['transportations'] = $transportations;

        // 
        // $routes = 
        $routes = [
            [
                'lat' => -7.52222811929988,
                'lng' => 112.41398625075817
            ],
            [
                'lat' => -7.52222811929988,
                'lng' => 112.41401977837086,
            ],
            [
                'lat' => -7.522654908864785, 
                'lng' => 112.41403721272945
            ]
        ];
        // $routes = [
        //     [
        //         'lat' => 2,
        //         'lng' => 3
        //     ],
        //     [
        //         'lat' => 5,
        //         'lng' => 10
        //     ],
        //     [
        //         'lat' => 4,
        //         'lng' => 2
        //     ]
        // ];
        // http://180.250.159.51:7777/api/navigation?origin=-7.522284,112.41350599999998&destination=-7.521199036192701,112.41389773786068

        // 
        $bestScore = INF;
        $bestScoreIndex = 0;
        for($i = 0; $i < count($routes); $i++)
        {
            $route = $routes[$i];
            $routes[$i]['latMin'] = ($route['lat'] - $data['origin']['lat']);
            $routes[$i]['lngMin'] = ($route['lng'] - $data['origin']['lng']);
            $routes[$i]['score'] = abs($routes[$i]['latMin'] + $routes[$i]['lngMin']);
            if ($routes[$i]['score'] < $bestScore) {
                $bestScore = $routes[$i]['score'];
                $bestScoreIndex = $i;
            }
        }

        //
        $data['bestCoordinate'] = $routes[$bestScoreIndex];
        $data['routes'] = $routes; 
        return $data;
    }
}
