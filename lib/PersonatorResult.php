<?php


    namespace Holtsdev\Personator;

    use Holtsdev\Personator\AddressRecord;

    class PersonatorResult {


        private $records = [];

        public function __construct(string $resultJson) {
            // Build class instance
            foreach (json_decode($resultJson, true) as $key => $value) {
                if ($key == 'Records') {
                    // Set up records array.
                    foreach ($value as $recordRow) {
                        array_push($this->records, new AddressRecord($recordRow));
                    }
                } else {
                    $this->{$key} = $value;
                }
            }
        }


        /**
         * This function will tell you whether the result from melissa contains a good address.
         * This may return true regardless of whether Melissa appends or changes the address.
         * @return bool
         */
        public function hasGoodAddress() {
            foreach($this->records as $record) {
                if ($record->hasGoodAddress()) {
                    // Then the address is fine.
                    return true;
                }
                return false;
            }
        }

        /**
         * This function tells you whether the result has changes. having an AC code means it has an address correction.
         * Which AC code(s) specifically tells you which portions have been changed.
         * @return bool
         */
        public function hasCorrections() {
            // AC code is address change  http://wiki.melissadata.com/index.php?title=Result_Codes&showObj=Address&ShowCodes=ShowCodes&ShowExamples=ShowExamples
            foreach($this->records as $record) {
                if ($record->hasCorrections()) {
                    return true;
                }
                return false;
            }
        }


    }