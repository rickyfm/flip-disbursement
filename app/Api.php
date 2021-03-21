<?php
namespace App;

/**
 *
 */
class Api
{
    public function request($url, $method, $data = null)
    {
        $curlHandler = curl_init();
        // print_r($data); die;
        curl_setopt_array($curlHandler, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        /**
         * Specify custom HTTP request method
         */
        CURLOPT_CUSTOMREQUEST => $method,

        /**
         * Specify request body (can be array or string)
         */
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => [
            "Authorization: Basic SHl6aW9ZN0xQNlpvTzduVFlLYkc4TzRJU2t5V25YMUp2QUVWQWh0V0tadW1vb0N6cXA0MTo=",
            "Content-Type: multipart/form-data"
        ],
    ]);

        $res = curl_exec($curlHandler);
        $error = curl_error($curlHandler);

        curl_close($curlHandler);

        if ($error) {
            echo "Error :" . $error;
        }

        return $res;
    }
}
