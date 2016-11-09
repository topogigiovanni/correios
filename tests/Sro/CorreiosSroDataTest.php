<?php
/**
 * This class help us to complete test the CorreiosSroData class.
 *
 * @author Ivan Wilhelm <ivan.whm@me.com>
 * @version 1.5
 * @abstract
 */

namespace correios\test\Sro;

use correios\Sro\CorreiosSroData;

class CorreiosSroDataTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests if the SRO number is invalid.
     *
     * @expectedException \Exception
     * @expectedExceptionMessage SRO number is invalid.
     */
    public function testSroNumberInvalid()
    {
        $data = new CorreiosSroData("SW592067298BR");
        print $data->getCode();
    }

    /**
     * Tests if the SRO number is correct.
     *
     */
    public function testCodeCorrect()
    {
        $data = new CorreiosSroData("SW592067296BR");
        $this->assertEquals($data->getCode(), "SW592067296BR");
    }

    /**
     * Tests if the service acronym is correct.
     */
    public function testServiceAcronymCorrect()
    {
        $data = new CorreiosSroData("SW592067296BR");
        $this->assertEquals($data->getServiceAcronym(), "SW");
    }

    /**
     * Tests if the service description is correct.
     */
    public function testServiceDescriptionCorrect()
    {
        $data = new CorreiosSroData("SW592067296BR");
        $this->assertEquals($data->getServiceDescription(), "E-SEDEX");
    }

    /**
     * Tests if the object code is correct.
     */
    public function testObjectCodeCorrect()
    {
        $data = new CorreiosSroData("SW592067296BR");
        $this->assertEquals($data->getObjectCode(), "59206729");
    }

    /**
     * Tests if the SRO digit is correct.
     */
    public function testDigitCorrect()
    {
        $data = new CorreiosSroData("SW592067296BR");
        $this->assertEquals($data->getDigit(), "6");
    }

    /**
     * Tests if the ISO2 from origin country is correct.
     */
    public function testOriginCountryCorrect()
    {
        $data = new CorreiosSroData("SW592067296BR");
        $this->assertEquals($data->getOriginCountry(), "BR");
    }

}