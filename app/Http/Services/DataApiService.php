<?php


namespace App\Http\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;

class DataApiService
{
    /**
     * @var string
     */
    private $serviceUrl;

    /**
     * @var string
     */
    private $method;

    public function __construct()
    {
        $this->serviceUrl = env("DATA_SERVICE_URL", 'https://eb8df37af130.ngrok.io/api/api_endpoint');
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createUser(array $data)
    {
        $this->method = __FUNCTION__;
        $requestData = $this->createJsonRpc($data);

        return $this->createRequest($requestData, 'POST');
    }

    /**
     * @param string $page_uid
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getData(string $page_uid, int $draw)
    {
        $this->method = __FUNCTION__;
        $requestData = $this->createJsonRpc(['page_uid' => $page_uid]);

        return $this->createJqueryDataTableData($this->createRequest($requestData), $draw);
    }

    /**
     * @param string $data
     * @param string $method
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createRequest(string $data, string $method = 'GET')
    {
        $client = new Client();
        $res = $client->request($method, $this->serviceUrl, [
            'body' => $data,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);

        $response = \GuzzleHttp\json_decode($res->getBody()->getContents());

        return $response->params;
    }

    /**
     * @param $data
     * @param int $draw
     * @return array
     */
    protected function createJqueryDataTableData($data, int $draw)
    {
        $formattedData = [
            'draw' => $draw,
            'recordsTotal' => count($data),
            'recordsFiltered' => count($data),
        ];

        if(count($data)) {
            $dataArr = [];
            foreach ($data as $value) {
                $dataArr[] = [$value->first_name, $value->second_name, $value->email, $value->page_uid, $value->created_at];
            }

            $formattedData['data'] = $dataArr;
        }

        return $formattedData;
    }

    /**
     * @param array $data
     * @return false|string
     */
    protected function createJsonRpc(array $data) : string
    {
        $requestData['method'] = $this->method;
        $paramsArray = [];
        foreach ($data as $key => $value) {
            if($key != '_token') {
                $paramsArray[$key] = $value;
            }
        }

        $requestData['params'][] = $paramsArray;

        return json_encode($requestData);
    }
}
