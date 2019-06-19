<?php


    namespace Holtsdev\Personator;


    class AddressRecord {

        private $resultCodes;

        // Codes can be found here: http://wiki.melissadata.com/index.php?title=Result_Code_Details#Address_Object
        // AS01, AS02, and AS03 are the codes that indicate no corrections are necessary
        //
        private $goodCodes = [
            'AS01',
            'AS02',
            'AS03'
        ];


        public function __construct(array $recordArray) {
            foreach($recordArray as $key => $value) {
                // explode(',', $record->Results
                if ($key == 'Results') {
                    $this->resultCodes = explode(',', $value);
                } else {
                    $this->{$key} = $value;
                }
            }
        }

        /**
         * This function tells you whether the result has changes. having an AC code means it has an address correction.
         * Which AC code(s) specifically tells you which portions have been changed.
         * @return bool
         */
        public function hasCorrections() {
            // AC code is address change  http://wiki.melissadata.com/index.php?title=Result_Codes&showObj=Address&ShowCodes=ShowCodes&ShowExamples=ShowExamples
            if (preg_grep('/^AC/', $this->resultCodes)) {
                    return true;
            }
            return false;
        }


        /**
         * This function tells you whether the result has changes. having an AC code means it has an address correction.
         * Which AC code(s) specifically tells you which portions have been changed.
         * @return bool
         */
        public function hasGoodAddress() {
            if (count(array_intersect($this->resultCodes, $this->goodCodes)) > 0) {
                // Then the address is fine.
                return true;
            }
            return false;
        }
    }