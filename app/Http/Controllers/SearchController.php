<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class SearchController extends Controller
{
    public function getSearchResults(Request $request)
    {
        $query = $request->input('query');
        $apiKey = '62da37ed0amsh6385db7038bbb71p12d03cjsn3d966127c579'; 
        $apiHost = 'google-search74.p.rapidapi.com'; 

        $client = new Client();

        try {
            
            $response = $client->request('GET', 'https://google-search74.p.rapidapi.com/?query=Nike&limit=10&related_keywords=true', [
                'headers' => [
                    'x-rapidapi-host' => $apiHost,
                    'x-rapidapi-key' => $apiKey,
                ],
                'query' => [
                    'query' => $query
                ],
                'verify' => false 
            ]);

            $data = json_decode($response->getBody(), true);
            return response()->json($data);

        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $message = json_decode($response->getBody()->getContents(), true)['message'];

            return response()->json(['error' => "Error fetching search results: $message"], $statusCode);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching search results: ' . $e->getMessage()], 500);
        }
    }
}
