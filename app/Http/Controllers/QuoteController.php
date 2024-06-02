<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class QuoteController extends Controller
{
    public function getRandomQuote(Request $request)
    {
        $apiKey = '62da37ed0amsh6385db7038bbb71p12d03cjsn3d966127c579'; 
        $apiHost = 'quotes-inspirational-quotes-motivational-quotes.p.rapidapi.com'; 

        $client = new Client();

        try {
            $response = $client->request('GET', 'https://quotes-inspirational-quotes-motivational-quotes.p.rapidapi.com/quote?token=ipworld.info', [
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

            return response()->json(['error' => "Error fetching quote: $message"], $statusCode);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching quote: ' . $e->getMessage()], 500);
        }
    }
}
