<?php

/**
 * This class help us to complete test the CorreiosSro class.
 *
 * @author Ivan Wilhelm <ivan.whm@me.com>
 * @version 1.5
 * @abstract
 */

namespace correios\test\Sro;

use correios\Sro\CorreiosSro;

class CorreiosSroTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests if there is a valid SRO number.
     */
    public function testValidateSroTrue()
    {
        $this->assertEquals(true, CorreiosSro::validateSro('SW592067296BR'));
    }

    /**
     * Tests if there is an invalid SRO number.
     */
    public function testValidateSroFalse()
    {
        $this->assertEquals(false, CorreiosSro::validateSro('SW00000000BR'));
    }

    /**
     * Tests if there is a valid digit on SRO number.
     */
    public function testCalculateSroDigitCorrect()
    {
        $this->assertEquals(CorreiosSro::calculateSroDigit(59206729), 6);
    }

    /**
     * Tests if there is an invalid SRO number passed.
     */
    public function testCalculateSroDigitInCorrect()
    {
        $this->assertEquals(CorreiosSro::calculateSroDigit(0), -1);
    }

}
