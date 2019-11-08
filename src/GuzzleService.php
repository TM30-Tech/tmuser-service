<?php
namespace TM30\TmUser;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class GuzzleService extends Client
{
    private $client;
    public function __construct()
    {
        parent::__construct();
        $this->client = new Client();
    }

    public function postRequest($url, $data = [], $header = [  'Accept' => 'application/json' ]) {
        try {
            $payload = $this->client->request('POST', $url, [
                'headers' => $header,
                'json' => $data
            ]);
            Log::info('Request was successful');
            return $this->successJsonResponse($payload);
        } catch (RequestException $e) {
            Log::error('There was an error with the POST Request');
            
            return $this->errorJsonResponse($e);
        }
    }

    public function getRequest($url, $params = [], $header = [  'Accept' => 'application/json' ]) {
        try {
            $payload = $this->client->request('GET', $url, [
                'headers' => $header,
                'query' => $params
            ]);
            return $this->successJsonResponse($payload);
        } catch (RequestException $e) {
            Log::error('There was an error with the Get Request');
            return $this->errorJsonResponse($e);
        }
    }

    public function putRequest($url, $data = [], $header =  [  'Accept' => 'application/json' ]) {
        try {
            $payload = $this->client->request('PUT', $url, [
                'headers' => $header,
                'json' => $data
            ]);
           return $this->successJsonResponse($payload);
        } catch (RequestException $e) {
            Log::error('There was an error with the PUT Request');
            return $this->errorJsonResponse($e);
        }
    }

    function successJsonResponse($payload) {
        return response ()->json ([
            'status' => 'success',
            'data' => json_decode($payload->getBody()->getContents(), true),
            'message' => 'Request was successful',
            "statusCode" => $payload->getStatusCode(),
            'raw' => $payload->getBody()
        ], $payload->getStatusCode() ?? 200);
    }

    function errorJsonResponse($e) {
        return response ()->json ([
            'status' => 'error',
            'data' =>  [],
            'statusCode' => $e->getCode(),
            'message' => 'Error details: '.$e->getMessage(),
        ], $e->getCode() ?? 400);
    }
}