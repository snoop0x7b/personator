<?php


    namespace Holtsdev\Personator;

    use Holtsdev\Personator\AddressRecord;

    class PersonatorResult {


        private $goodCodes = [
            'AS01',
            'ASO2',
            'AS03'
        ];

        private $records = [];

        public function __construct(string $resultJson) {
            // Build class instance
            foreach (json_decode($resultJson, true) as $key => $value) {
                if ($key == 'records') {
                    // Set up records array.
                    foreach ($value as $recordRow) {
                        array_push($this->records, new AddressRecord($recordRow));
                    }
                } else {
                    $this->{$key} = $value;
                }
            }
        }


        public function hasGoodAddress() {

        }

        public function hasCorrections() {

        }


    }