<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class NewsController extends Controller
{
    public function getLatestNews(Request $request)
    {
        $apiKey = '62da37ed0amsh6385db7038bbb71p12d03cjsn3d966127c579'; 
        $apiHost = 'nba-latest-news.p.rapidapi.com'; 

        $client = new Client();

        try {
            $response = $client->request('GET', 'https://nba-latest-news.p.rapidapi.com/articles', [
                'headers' => [
                    'x-rapidapi-host' => $apiHost,
                    'x-rapidapi-key' => $apiKey,
                ],
                'query' => [
        
                ],
                'verify' => false 
            ]);

            $data = json_decode($response->getBody(), true);
            return response()->json($data);

        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $message = json_decode($response->getBody()->getContents(), true)['message'];

            return response()->json(['error' => "Error fetching news data: $message"], $statusCode);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching news data: ' . $e->getMessage()], 500);
        }
    }
}
