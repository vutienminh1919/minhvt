<?php

namespace App\Lib\partner;

class VietQr
{
    public $client_id = "5e319e0e-eb5a-4cdc-bef9-8464474a7f46";
    public $api_key = "ae2fdd49-88b6-4da0-b2a1-cb3381d13786";
    public $base_url = "https://api.vietqr.io/v2/";
    public $inputs = [];
    public $api_url = "";
    public $response = [];



    public function call($params, $endpoint, $method = "GET")
    {

        try {
            $header = [
                "Content-Type: application/json",
                "x-client-id: " . $this->client_id,
                "x-api-key: " . $this->api_key,
            ];
            $this->inputs = json_encode($params);
            if (!empty($endpoint)) {
                $this->api_url = $this->base_url . $endpoint;
            }

            $curl = curl_init();



            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_POSTFIELDS => $this->inputs,
                CURLOPT_HTTPHEADER => $header

            ));

            $response = curl_exec($curl);
            $resultCode = curl_getinfo($curl);

            curl_close($curl);
            if($resultCode['http_code'] == 200){

                $this->response = json_decode($response, true);
            }
            return $this->response;


        } catch (\Exception $e) {

        }


    }

}
