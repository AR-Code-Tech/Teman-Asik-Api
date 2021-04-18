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
            ->select('id', 'name', 'description', 'cost')
            ->get();
        
        $result = [];
        $bestScore = INF;
        $bestScoreIndex = null;
        for ($i=0; $i < count($transportations); $i++) { 
            $tmp = $this->_getRouting($data['origin'], $data['destination'], $transportations[$i]);
            $tmp['distance'] = (double) $this->_getCost($tmp);
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
        //	$result = json_decode(json_encode(unserialize(str_replace(array('NAN;','INF;'),'0;',serialize($data)))));
        //	return response()->json($result);
        //	dd($data);
        return $data;
    }

    private function _getCost($transportation)
    {
        $start = $transportation['closestPointFromOrigin'];
        $end = $transportation['closestPointFromDestination'];
        $distance = $this->_getDistance(
            $start->latitude, $start->longitude,
            $end->latitude, $end->longitude,
        );
        $result = [
            'start' => $start,
            'end' => $end,
            'distance' => number_format($distance, 2),
        ];
        return number_format($distance, 2);
    }

    private function _getDistance($lat1, $lon1, $lat2, $lon2, $unit = 'K') {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
      
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
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
