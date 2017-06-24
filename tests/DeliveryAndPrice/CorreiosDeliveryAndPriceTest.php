<?php
/**
 * This class help us to complete test the CorreiosDeliveryAndPrice class.
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 * @version 1.0
 * @abstract
 */

namespace correios\test\DeliveryAndPrice;

use correios\Correios;
use correios\DeliveryAndPrice\CorreiosDeliveryAndPrice;
use DateTime;
use Exception;
use PHPUnit_Framework_TestCase;

class CorreiosDeliveryAndPriceTest extends PHPUnit_Framework_TestCase
{
    /**
     * Contains the object related with the test class.
     * @var CorreiosDeliveryAndPrice
     */
    private $data;

    /**
     * Tests if the service is correct.
     */
    public function testsAddServiceCorrect()
    {
        $this->getData()->addService(Correios::SERVICE_SEDEX_WITH_CONTRACT_1);
    }

    /**
     * Returns the object to do the tests.
     *
     * @return CorreiosDeliveryAndPrice
     */
    private function getData()
    {
        date_default_timezone_set('America/Sao_Paulo');
        if (!($this->data instanceof CorreiosDeliveryAndPrice))
            $this->data = new CorreiosDeliveryAndPrice('user', 'password', Correios::CALCULATION_TYPE_ALL_PRICE);
        return $this->data;
    }

    /**
     * Tests if the service is incorrect.
     *
     * @expectedException Exception
     * @expectedExceptionMessage The service code is invalid.
     */
    public function testsAddServiceIncorrect()
    {
        $this->getData()->addService('123');
    }

    /**
     * Tests if the initiating zip code is correct.
     */
    public function testsInitiatingZipCodeCorrect()
    {
        $this->getData()->setInitiatingZipCode('89010000');
    }

    /**
     * Tests if the receiving zip code is correct.
     */
    public function testsReceivingZipCodeCorrect()
    {
        $this->getData()->setReceivingZipCode('890101001');
    }

    /**
     * Tests if the package weight is correct.
     */
    public function testsPackageWeightCorrect()
    {
        $this->getData()->setPackageWeight(123.9);
    }

    /**
     * Tests if the package weight is incorrect.
     *
     * @expectedException Exception
     * @expectedExceptionMessage The weight is invalid.
     */
    public function testsPackageWeightIncorrect()
    {
        $this->getData()->setPackageWeight(123);
    }

    /**
     * Tests if the package shape is correct.
     */
    public function testsPackageShapeCorrect()
    {
        $this->getData()->setPackageShape(Correios::PACKAGE_SHAPE_BOX_PARCEL);
    }

    /**
     * Tests if the package shape is incorrect.
     *
     * @expectedException Exception
     * @expectedExceptionMessage The shape of the package is invalid.
     */
    public function testsPackageShapeIncorrect()
    {
        $this->getData()->setPackageShape(4);
    }

    /**
     * Tests if the package length is correct.
     */
    public function testsPackageLengthCorrect()
    {
        $this->getData()->setPackageLength(123.9);
    }

    /**
     * Tests if the package length is incorrect.
     *
     * @expectedException Exception
     * @expectedExceptionMessage The length of the package is invalid.
     */
    public function testsPackageLengthIncorrect()
    {
        $this->getData()->setPackageLength(123);
    }

    /**
     * Tests if the package height is correct.
     */
    public function testsPackageHeightCorrect()
    {
        $this->getData()->setPackageHeight(123.9);
    }

    /**
     * Tests if the package height is incorrect.
     *
     * @expectedException Exception
     * @expectedExceptionMessage The height of the package is invalid.
     */
    public function testsPackageHeightIncorrect()
    {
        $this->getData()->setPackageHeight(123);
    }

    /**
     * Tests if the package width is correct.
     */
    public function testsPackageWidthCorrect()
    {
        $this->getData()->setPackageWidth(123.9);
    }

    /**
     * Tests if the package width is incorrect.
     *
     * @expectedException Exception
     * @expectedExceptionMessage The width of the package is invalid.
     */
    public function testsPackageWidthIncorrect()
    {
        $this->getData()->setPackageWidth(123);
    }

    /**
     * Tests if the package diameter is correct.
     */
    public function testsPackageDiameterCorrect()
    {
        $this->getData()->setPackageDiameter(0.9);
    }

    /**
     * Tests if the package diameter is incorrect.
     *
     * @expectedException Exception
     * @expectedExceptionMessage The diameter of the package is invalid.
     */
    public function testsPackageDiameterIncorrect()
    {
        $this->getData()->setPackageDiameter(0);
    }

    /**
     * Tests if the service called "Own Hands" service is correct.
     */
    public function testsOwnHandsServiceCorrect()
    {
        $this->getData()->hasOwnHandsService(true);
    }

    /**
     * Tests if the service called "Own Hands" service is incorrect.
     *
     * @expectedException Exception
     * @expectedExceptionMessage The additional service called "Own Hands" is invalid.
     */
    public function testsOwnHandsServiceIncorrect()
    {
        $this->getData()->hasOwnHandsService('false1');
    }

    /**
     * Tests if the price of called "Declared Product Price" is correct.
     */
    public function testsDeclaredProductPriceServiceCorrect()
    {
        $this->getData()->hasDeclaredProductPriceService(123.9);
    }

    /**
     * Tests if the price of called "Declared Product Price" is incorrect.
     *
     * @expectedException Exception
     * @expectedExceptionMessage The additional service called "Declared Product Price" is invalid.
     */
    public function testsDeclaredProductPriceServiceIncorrect()
    {
        $this->getData()->hasDeclaredProductPriceService(123);
    }

    /**
     * Tests if the service called "Receipt Notice" is correct.
     */
    public function testsReceiptNoticeServiceCorrect()
    {
        $this->getData()->hasReceiptNoticeService(true);
    }

    /**
     * Tests if the service called "Receipt Notice" is incorrect.
     *
     * @expectedException Exception
     * @expectedExceptionMessage The additional service called "Receipt Notice" is invalid.
     */
    public function testsReceiptNoticeServiceIncorrect()
    {
        $this->getData()->hasReceiptNoticeService('false1');
    }

    /**
     * Tests if the calculation date base is correct.
     */
    public function testsCalculationDateBaseCorrect()
    {
        $date = new DateTime();
        $date->setDate(2018, 12, 3);
        $this->getData()->setCalculationDateBase($date);
        $this->assertEquals('03/12/2018', $this->getData()->getCalculationDateBase()->format('d/m/Y'));
    }

    /**
     * Tests if the calculation date base is incorrect.
     */
    public function testsCalculationDateBaseIncorrect()
    {
        $date = new DateTime();
        $date->setDate(2018, 12, 3);
        $this->getData()->setCalculationDateBase($date);
        $this->assertNotEquals('02/11/2017', $this->getData()->getCalculationDateBase()->format('d/m/Y'));
    }

    /**
     * Tests if the calculation type is correct.
     */
    public function testsCalculationTypeCorrect()
    {
        $this->assertEquals(Correios::CALCULATION_TYPE_ALL_PRICE, $this->getData()->getCalculationType());
    }

    /**
     * Tests if the calculation type is incorrect.
     *
     * @expectedException Exception
     * @expectedExceptionMessage The calculation type is invalid.
     */
    public function testsCalculationTypeIncorrect()
    {
        new CorreiosDeliveryAndPrice('user', 'password', '123');
    }

}