<?php

    namespace Holtsdev\Personator;

    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\GuzzleException;
    use InvalidArgumentException;

    /**
     * Class Personator
     * Implementation for the Melissa Data personator. See: https://www.melissa.com/developer/personator
     * @package Holtsdev\Personator
     */
class Personator {


    private $personatorUrl = "https://personator.melissadata.net/v3/WEB/ContactVerify/doContactVerify";

    const CHECK = 'Check';
    const VERIFY = 'Verify';
    const MOVE = 'Move';
    const APPEND = 'Append';

    private $validActions = [
        CHECK,
        VERIFY,
        MOVE,
        APPEND
    ];

    private $licenseKey;

    /**
     * Personator constructor.
     * @param string $licenseKey - Melissa license key for your account
     */
    public function __construct(string $licenseKey) {
        $this->licenseKey = $licenseKey;
    }


    /**
     *
     * @param array $actions Valid actions include Check, Verify, Append, Move
     * @param array $addressParams Address parameters defining the address you intend to look up.
     * @return PersonatorResult
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    public function doRequest(array $actions, array $addressParams) {
        if (count($actions) != 0 && count($actions) == count(array_intersect($actions, $this->validActions))) {
            throw new InvalidArgumentException("Actions may only be one or more of: " . implode(',',$this->validActions));
        }
        // Instantiate a GuzzleHttp client
        $client = new Client();

        // Build our parameter set
        $params['id'] = $this->licenseKey;
        // JSON only because that's what this library is designed to process.
        $params['format'] = 'json';
        $params = array_merge($params, $addressParams);
        $params['act'] = implode(',', $actions);
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