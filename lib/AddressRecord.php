<?php


    namespace Holtsdev\Personator;


    class AddressRecord {

        public function __construct(array $recordArray) {
            foreach($recordArray as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }