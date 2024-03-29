<?php


    namespace Holtsdev\Personator;

    use Holtsdev\Personator\AddressRecord;
    use Rakshazi\GetSetTrait;

    class PersonatorResult {


        private $records = [];

        private $TotalRecords;
        private $TransmissionReference;
        private $TransmissionResults;
        private $Version;

        use GetSetTrait;

        /**
         * PersonatorResult constructor.
         * @param string $resultJson
         */
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
         * @return boolean
         */
        public function hasGoodAddress(): bool {
            foreach($this->records as $record) {
                if ($record->hasGoodAddress()) {
                    // Then the address is fine.
                    return true;
                }
            }
            return false;
        }

        /**
         * This function tells you whether the result has changes. having an AC code means it has an address correction.
         * Which AC code(s) specifically tells you which portions have been changed.
         * @return boolean
         */
        public function hasCorrections(): bool {
            // AC code is address change  http://wiki.melissadata.com/index.php?title=Result_Codes&showObj=Address&ShowCodes=ShowCodes&ShowExamples=ShowExamples
            foreach($this->records as $record) {
                if ($record->hasCorrections()) {
                    return true;
                }
            }
            return false;
        }

        /**
         * @return array
         */
        public function getRecords() {
            return $this->records;
        }

        /**
         * @return mixed
         */
        public function getTotalRecords(): int {
            return $this->TotalRecords;
        }

        /**
         * @return mixed
         */
        public function getTransmissionReference() {
            return $this->TransmissionReference;
        }

        /**
         * @return mixed
         */
        public function getTransmissionResults() {
            return $this->TransmissionResults;
        }

        /**
         * @return mixed
         */
        public function getVersion() {
            return $this->Version;
        }



    }