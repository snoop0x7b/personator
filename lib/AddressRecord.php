<?php


    namespace Holtsdev\Personator;


    use Rakshazi\GetSetTrait;

    class AddressRecord {

        private $resultCodes;


        // Define basic fields
        private $AddressExtras;
        private $AddressKey;
        private $AddressLine1;
        private $AddressLine2;
        private $City;
        private $CompanyName;
        private $EmailAddress;
        private $MelissaAddressKey;
        private $MelissaAddressKeyBase;
        private $NameFull;
        private $PhoneNumber;
        private $PostalCode;
        private $RecordExtras;
        private $RecordID;
        private $Reserved;
        private $State;

        use GetSetTrait;

        // Codes can be found here: http://wiki.melissadata.com/index.php?title=Result_Code_Details#Address_Object
        // AS01, AS02, and AS03 are the codes that indicate no corrections are necessary
        //
        private $goodCodes = [
            'AS01',
            'AS02',
            'AS03'
        ];


        public function __construct(array $recordArray) {
            foreach ($recordArray as $key => $value) {
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
        public function hasCorrections(): bool {
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
        public function hasGoodAddress(): bool {
            if (count(array_intersect($this->resultCodes, $this->goodCodes)) > 0) {
                // Then the address is fine.
                return true;
            }
            return false;
        }

        /**
         * @return array
         */
        public function getResultCodes() {
            return $this->resultCodes;
        }

        /**
         * @return mixed
         */
        public function getAddressExtras() {
            return $this->AddressExtras;
        }

        /**
         * @return mixed
         */
        public function getAddressKey(): string {
            return $this->AddressKey;
        }

        /**
         * @return mixed
         */
        public function getAddressLine1(): string {
            return $this->AddressLine1;
        }

        /**
         * @return mixed
         */
        public function getAddressLine2(): ?string {
            return $this->AddressLine2;
        }

        /**
         * @return mixed
         */
        public function getCity(): string {
            return $this->City;
        }

        /**
         * @return mixed
         */
        public function getCompanyName(): ?string {
            return $this->CompanyName;
        }

        /**
         * @return mixed
         */
        public function getEmailAddress(): ?string {
            return $this->EmailAddress;
        }

        /**
         * @return mixed
         */
        public function getMelissaAddressKey(): ?string {
            return $this->MelissaAddressKey;
        }

        /**
         * @return mixed
         */
        public function getMelissaAddressKeyBase(): ?string {
            return $this->MelissaAddressKeyBase;
        }

        /**
         * @return mixed
         */
        public function getNameFull(): ?string {
            return $this->NameFull;
        }

        /**
         * @return mixed
         */
        public function getPhoneNumber(): ?string {
            return $this->PhoneNumber;
        }

        /**
         * @return mixed
         */
        public function getPostalCode(): ?string {
            return $this->PostalCode;
        }

        /**
         * @return mixed
         */
        public function getRecordExtras() {
            return $this->RecordExtras;
        }

        /**
         * @return mixed
         */
        public function getRecordID() {
            return $this->RecordID;
        }

        /**
         * @return mixed
         */
        public function getReserved() {
            return $this->Reserved;
        }

        /**
         * @return mixed
         */
        public function getState() {
            return $this->State;
        }

    }