<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transportation;
use App\Models\TransportationRoutes;
use Illuminate\Support\Collection;

use function PHPUnit\Framework\returnValue;

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

        // get all prediction
        $transportations = Transportation::with('routes')
            ->select('id', 'name', 'description')
            ->get();
        
        $result = [];
        $bestScore = INF;
        $bestScoreIndex = null;
        for ($i=0; $i < count($transportations); $i++) { 
            $tmp = $this->_getRouting($data['origin'], $data['destination'], $transportations[$i]);
            if ($bestScore > $tmp['score']) {
                $bestScoreIndex = $i;
                $bestScore = $tmp['score'];
            }
            $result[] = $tmp;
        }

        // 
        usort($result, function($first, $second){
            return $first['score'] > $second['score'];
        });

        // 
        $data['best'] = $result[$bestScoreIndex];
        $data['transportations'] = $result;
        return $data;
    }


    private function _getRouting($origin, $destination, $transportation)
    {
        // 
        // $transportation = $transportation->toArray
        $routes = $transportation->routes;

        // 
        $data = $transportation->toArray();

        // get closed list from destination
        $closestDistance = INF;
        $closestPoint = null;
        for($i = 0; $i < count($routes); $i++)
        {
            $route = $routes[$i];
            $distance = $this->vincentyGreatCircleDistance(
                $route['latitude'], $route['longitude'],
                $destination['lat'], $destination['lng'],
            );
            if ($distance < $closestDistance) {
                $closestPoint = $route;
                $closestDistance = $distance;
            }
        }
        $data['closestPointFromDestination'] = $closestPoint;
        $data['scoreDestination'] = $closestDistance;


        // get closed list from origin
        $closestDistance = INF;
        $closestPoint = null;
        for($i = 0; $i < count($routes); $i++)
        {
            $route = $routes[$i];
            $distance = $this->vincentyGreatCircleDistance(
                $route['latitude'], $route['longitude'],
                $origin['lat'], $origin['lng'],
            );
            if ($distance < $closestDistance) {
                $closestPoint = $route;
                $closestDistance = $distance;
            }
        }
        $data['closestPointFromOrigin'] = $closestPoint;
        $data['scoreOrigin'] = $closestDistance;

        // 
        $data['score'] = $data['scoreOrigin'] + $data['scoreDestination'];
        $data['routes'] = $transportation->routes;
        return $data;
    }
}
