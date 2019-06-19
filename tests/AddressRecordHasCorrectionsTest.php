<?php


    use Holtsdev\Personator\AddressRecord;
    use PHPUnit\Framework\TestCase;

    class AddressRecordHasCorrectionsTest extends TestCase {

        public function testHasCorrections() {
            // AC10 result is a correction
            $addressRecordWithCorrections = new AddressRecord(
                [
                    'Results' => 'AC10,AS01,VR01'
                ]
            );
            $this->assertTrue($addressRecordWithCorrections->hasCorrections());

            $addressRecordWithOutCorrections = new AddressRecord(
                [
                    'Results' => 'AS01,VR01'
                ]
            );

            $this->assertFalse($addressRecordWithOutCorrections->hasCorrections());
        }

        public function testHasGoodAddress() {
            $goodCodes = [
                'AS01',
                'AS02',
                'AS03'
            ];
            foreach($goodCodes as $goodCode) {
                $addressRecord = new AddressRecord( [
                    'Results' => $goodCode
                ]);
                $this->assertTrue($addressRecord->hasGoodAddress());
            }
            $addressRecord = new AddressRecord([
                'Results' => ''
            ]);
            $this->assertFalse($addressRecord->hasGoodAddress());
        }
    }
