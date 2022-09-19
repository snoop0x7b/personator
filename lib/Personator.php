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
    const FIRSTNAME = 'first';
    const LASTNAME = 'last';
    const ADDRESSLINE1 = 'a1';
    const ADDRESSLINE2 = 'a2';
    const STATE = 'state';
    const CITY = 'city';
    const POSTALCODE = 'postal';
    const COLUMNS = 'cols';
    const ADDRESSTYPECODE = 'AddressTypeCode';
    const DELIVERYINDICATOR = 'DeliveryIndicator';

    private $personatorUrl = "https://personator.melissadata.net/v3/WEB/ContactVerify/doContactVerify";

    const CHECK = 'Check';
    const VERIFY = 'Verify';
    const MOVE = 'Move';
    const APPEND = 'Append';

    private $validActions = [
        self::CHECK,
        self::VERIFY,
        self::MOVE,
        self::APPEND
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
     * @throws PersonatorRequestException
     */
    public function doRequest(array $actions, array $addressParams) {
        if (count($actions) === 0 || (count($actions) != count(array_intersect($actions, $this->validActions))) ) {
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
            throw new PersonatorRequestException('Invalid response from melissa! ' .$response->getStatusCode());
        }

        $result = new PersonatorResult($response->getBody());
        return $result;
    }


}
