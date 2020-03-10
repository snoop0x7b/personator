<?php


    use PHPUnit\Framework\TestCase;

    class ArgumentsSaneTest extends TestCase {

        public final function testIllegalArgumentExtraParam() {
            $this->expectException(InvalidArgumentException::class);
            $personator = new \Holtsdev\Personator\Personator('DOESNTMATTER');
            $result = $personator->doRequest(array(\Holtsdev\Personator\Personator::VERIFY,
                \Holtsdev\Personator\Personator::APPEND, 'Meow'), array()); // Second parameter doesn't actually matter

        }

        public final function testIllegalArgumentEmptyArrays() {
            $this->expectException(InvalidArgumentException::class);
            $personator = new \Holtsdev\Personator\Personator('DOESNTMATTER');
            $result = $personator->doRequest(array(), array());
        }

        public final function testIllegalArgumentNull() {
            $this->expectException(TypeError::class);
            $personator = new \Holtsdev\Personator\Personator('DOESNTMATTER');
            $result = $personator->doRequest(null, array());
        }

        public final function testIllegalArgumentJustWrong() {
            $this->expectException(InvalidArgumentException::class);
            $personator = new \Holtsdev\Personator\Personator('DOESNTMATTER');
            $result = $personator->doRequest(array('meow'), array());
        }

        public final function testHasGoodArgumentRequestType() {
            $personator = new \Holtsdev\Personator\Personator('DOESNTMATTER');
            $result = $personator->doRequest(array(\Holtsdev\Personator\Personator::VERIFY, \Holtsdev\Personator\Personator::APPEND), array());
            $this->assertEquals(1,1); // Dummy assertion, if no exception was thrown before this we know we're good.
        }
    }

