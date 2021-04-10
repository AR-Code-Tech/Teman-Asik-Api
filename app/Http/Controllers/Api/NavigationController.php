<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transportation;
use App\Models\TransportationRoutes;
use Illuminate\Support\Collection;

class NavigationController extends Controller
{
    public function vincentyGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);
        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);
        
        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
    }

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
        $routes = TransportationRoutes::select('id', 'transportation_id', 'latitude', 'longitude')->get();
        $routes = new Collection($routes);
        $routes_list = $routes->map(function (TransportationRoutes $e) {
            return ['id' => $e->id, 'transportation_id' => $e->transportation_id, 'lat' => $e->latitude, 'lng' => $e->longitude];
        });


        // get closed list from destination
        $closestDistance = INF;
        $closestPoint = null;
        $zero = 0;
        for($i = 0; $i < count($routes_list); $i++)
        {
            $route = $routes_list[$i];
            $distance = $this->vincentyGreatCircleDistance(
                $route['lat'], $route['lng'],
                $data['destination']['lat'], $data['destination']['lng'],
            );
            if ($distance < $closestDistance) {
                $closestPoint = $route;
                $closestDistance = $distance;
            }
        }
        $data['closestPointFromDestination'] = $closestPoint; 


        // get list route from transporation
        $routes = TransportationRoutes::select('id', 'transportation_id', 'latitude', 'longitude')
            ->where('transportation_id', $data['closestPointFromDestination']['transportation_id'])
            ->get();
        $routes = new Collection($routes);
        $routes_list = $routes->map(function (TransportationRoutes $e) {
            return ['id' => $e->id, 'transportation_id' => $e->transportation_id, 'lat' => $e->latitude, 'lng' => $e->longitude];
        });

        // get closed list from origin
        $closestDistance = INF;
        $closestPoint = null;
        $zero = 0;
        for($i = 0; $i < count($routes_list); $i++)
        {
            $route = $routes_list[$i];
            $distance = $this->vincentyGreatCircleDistance(
                $route['lat'], $route['lng'],
                $data['origin']['lat'], $data['origin']['lng'],
            );
            if ($distance < $closestDistance) {
                $closestPoint = $route;
                $closestDistance = $distance;
            }
        }
        $data['closestPointFromOrigin'] = $closestPoint; 

        // 
        $data['transportation'] = Transportation::find($closestPoint['transportation_id']);
        $data['transportation']->load('routes');

        // 
        // $data['routes'] = $routes; 
        return $data;
        // $routes = [
        //     [
        //         'lat' => -7.52222811929988,
        //         'lng' => 112.41398625075817
        //     ],
        //     [
        //         'lat' => -7.52222811929988,
        //         'lng' => 112.41401977837086,
        //     ],
        //     [
        //         'lat' => -7.522654908864785, 
        //         'lng' => 112.41403721272945
        //     ]
        // ];
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
