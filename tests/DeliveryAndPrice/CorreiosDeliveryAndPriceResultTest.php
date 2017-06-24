<?php
/**
 * This class help us to complete test the CorreiosDeliveryAndPriceResult class.
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 * @version 1.0
 * @abstract
 */

namespace correios\test\DeliveryAndPrice;

use correios\Correios;
use correios\DeliveryAndPrice\CorreiosDeliveryAndPriceResult;
use PHPUnit_Framework_TestCase;
use stdClass;

class CorreiosDeliveryAndPriceResultTest extends PHPUnit_Framework_TestCase
{

    /**
     * Returns a class with data to validate the tests.
     *
     * @return stdClass
     */
    private function getData()
    {
        $data = new stdClass();
        $data->Codigo =  Correios::SERVICE_SEDEX_WITH_CONTRACT_1;
        $data->Erro = '1';
        $data->MsgErro = 'This is an error.';
        $data->PrazoEntrega =  12;
        $data->EntregaDomiciliar = 'S';
        $data->EntregaSabado = 'N';
        $data->Valor = '123,45';
        $data->ValorMaoPropria = '56,78';
        $data->ValorAvisoRecebimento = '0,78';
        $data->ValorValorDeclarado = '2,90';
        return $data;
    }

    /**
     * Tests if the service code is correct.
     */
    public function testServiceCodeCorrect()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertEquals('40096', $delivery->getServiceCode());
    }

    /**
     * Tests if the service code is incorrect.
     */
    public function testServiceCodeIncorrect()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertNotEquals('40098', $delivery->getServiceCode());
    }

    /**
     * Tests if the price to shipping is correct.
     */
    public function testShippingPriceCorrect()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertEquals(123.45, $delivery->getShippingPrice());
    }

    /**
     * Tests if the price to shipping is incorrect.
     */
    public function testShippingPriceIncorrect()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertNotEquals(123.46, $delivery->getShippingPrice());
    }

    /**
     * Tests if the delivery days is correct.
     */
    public function testDeliveryDaysCorrect()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertEquals(12, $delivery->getDeliveryDays());
    }

    /**
     * Tests if the delivery days is incorrect.
     */
    public function testDeliveryDaysIncorrect()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertNotEquals(11, $delivery->getDeliveryDays());
    }

    /**
     * Tests if the price to additional service own hands is correct.
     */
    public function testPriceServiceOwnHandsCorrect()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertEquals(56.78, $delivery->getPriceServiceOwnHands());
    }

    /**
     * Tests if the price to additional service own hands is incorrect.
     */
    public function testPriceServiceOwnHandsIncorrect()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertNotEquals(56, $delivery->getPriceServiceOwnHands());
    }

    /**
     * Tests if the price to additional service receipt notice is correct.
     */
    public function testPriceServiceReceiptNoticeCorrect()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertEquals(0.78, $delivery->getPriceServiceReceiptNotice());
    }

    /**
     * Tests if the price to additional service receipt notice is incorrect.
     */
    public function testPriceServiceReceiptNoticeIncorrect()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertNotEquals(1.78, $delivery->getPriceServiceReceiptNotice());
    }

    /**
     * Tests if the price to additional service declared product price is correct.
     */
    public function testPriceServiceDeclaredProductPriceCorrect()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertEquals(2.9, $delivery->getPriceServiceDeclaredProductPrice());
    }

    /**
     * Tests if the price to additional service declared product price is incorrect.
     */
    public function testPriceServiceDeclaredProductPriceIncorrect()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertNotEquals(2.91, $delivery->getPriceServiceDeclaredProductPrice());
    }

    /**
     * Tests if the shipping is delivery at home.
     */
    public function testDeliveryAtHomeTrue()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertEquals(true, $delivery->getDeliveryAtHome());
    }

    /**
     * Tests if the shipping is not delivery at home.
     */
    public function testDeliveryAtHomeFalse()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertNotEquals(false, $delivery->getDeliveryAtHome());
    }

    /**
     * Tests if the shipping is delivery on saturday.
     */
    public function testDeliveryOnSaturdayTrue()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertEquals(false, $delivery->getDeliveryOnSaturday());
    }

    /**
     * Tests if the shipping is not delivery on saturday.
     */
    public function testDeliveryOnSaturdayFalse()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertNotEquals(true, $delivery->getDeliveryOnSaturday());
    }

    /**
     * Tests if the error code is correct.
     */
    public function testErrorCodeCorrect()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertEquals(1, $delivery->getErrorCode());
    }

    /**
     * Tests if the error code is not correct.
     */
    public function testErrorCodeIncorrect()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertNotEquals(2, $delivery->getErrorCode());
    }

    /**
     * Tests if the error message is correct.
     */
    public function testErrorMessageCorrect()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertEquals('This is an error.', $delivery->getErrorMessage());
    }

    /**
     * Tests if the error message is incorrect.
     */
    public function testErrorMessageIncorrect()
    {
        $delivery = new CorreiosDeliveryAndPriceResult($this->getData(), Correios::CALCULATION_TYPE_ALL_PRICE);
        $this->assertNotEquals('This is not an error.', $delivery->getErrorMessage());
    }
}