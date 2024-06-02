<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $city = $request->input('city');
        $apiKey = '62da37ed0amsh6385db7038bbb71p12d03cjsn3d966127c579';
        $apiHost = 'open-weather13.p.rapidapi.com';

        $client = new Client();

        try {
            $response = $client->request('GET', 'https://open-weather13.p.rapidapi.com/city/landon/EN', [
                'headers' => [
                    'x-rapidapi-host' => $apiHost,
                    'x-rapidapi-key' => $apiKey,
                ],
                'verify' => false 
            ]);

            $data = json_decode($response->getBody(), true);
            return response()->json($data);

        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $message = json_decode($response->getBody()->getContents(), true)['message'];

            return response()->json(['error' => "Error fetching weather data: $message"], $statusCode);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching weather data: ' . $e->getMessage()], 500);
        }
    }
}
