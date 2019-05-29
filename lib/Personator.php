<?php

    namespace Holtsdev\Personator;

    use Holtsdev\Personator\PersonatorResult;
    use GuzzleHttp\Client;

class Personator {


    private $personatorUrl = "https://personator.melissadata.net/v3/WEB/ContactVerify/doContactVerify";


    private $licenseKey;

    public function __construct($licenseKey) {
        $this->licenseKey = $licenseKey;
    }


    /**
     * @return PersonatorResult
     */
    public function doRequest($params) {

        $client = new \GuzzleHttp\Client();
        $params['id'] = $this->licenseKey;
        // JSON only because that's what this library is designed to process.
        $params['format'] = 'json';
        $response = $client->request('GET', $this->personatorUrl, [
            'query' => $params
        ] );
        if ($response->getStatusCode() != 200) {
            throw new Exception('Invalid response from melissa! ' .$response->getStatusCode());
        }

        $result = new PersonatorResult($response->getBody());
        return $result;
    }


}