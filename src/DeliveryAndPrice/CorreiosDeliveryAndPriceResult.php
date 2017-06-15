<?php

/**
 * Class to deal with the Correios webservice and process the received information.
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 * @version 1.3
 * @see /docs/delivery_and_price/version_1_9.pdf
 * @final
 */

namespace correios\DeliveryAndPrice;

use correios\Correios;
use stdClass;

final class CorreiosDeliveryAndPriceResult
{

    /**
     * Contains the used delivery service code.
     *
     * @see Correios::$services
     * @var string
     */
    private $serviceCode;

    /**
     * Contains the total shipping price for the delivery service.
     *
     * @var float
     */
    private $shippingPrice;

    /**
     * Contains the amount of days to delivery.
     *
     * @var integer
     */
    private $deliveryDays;

    /**
     * Contains the price for the additional service called "own hands".
     *
     * @var float
     */
    private $priceServiceOwnHands;

    /**
     * Contains the price for the additional service called "receipt notice".
     *
     * @var float
     */
    private $priceServiceReceiptNotice;

    /**
     * Contains the price for the additional service called "declared product price".
     *
     * @var float
     */
    private $priceServiceDeclaredProductPrice;

    /**
     * Contains if the delivery service, delivery at home.
     *
     * @var boolean
     */
    private $deliveryAtHome;

    /**
     * Contains if the delivery service, delivery on Saturday.
     *
     * @var boolean
     */
    private $deliveryOnSaturday;

    /**
     * Contains the error code of the WebService return.
     * When returns 0, indicates that has not an error.
     *
     * @var integer
     */
    private $errorCode;

    /**
     * Contains the error message of the WebService return.
     *
     * @var string
     */
    private $errorMessage;

    /**
     * Creates an object to process the WebService return.
     *
     * @see Correios::$calculationTypes
     * @param stdClass $webServiceReturn WebService return.
     * @param string $calculationType Calculation type.
     */
    public function __construct(stdClass $webServiceReturn, $calculationType)
    {

        $this->setServiceCode($webServiceReturn->Codigo);
        $this->setErrorCode($webServiceReturn->Erro);
        $this->setErrorMessage($webServiceReturn->MsgErro);

        if ($this->returnsDelivery($calculationType))
        {
            $this->setDeliveryDays($webServiceReturn->PrazoEntrega);
            $this->setDeliveryAtHome($webServiceReturn->EntregaDomiciliar);
            $this->setDeliveryOnSaturday($webServiceReturn->EntregaSabado);
        }

        if ($this->returnsPrice($calculationType))
        {
            $this->setShippingPrice($webServiceReturn->Valor);
            $this->setPriceServiceOwnHands($webServiceReturn->ValorMaoPropria);
            $this->setPriceServiceReceiptNotice($webServiceReturn->ValorAvisoRecebimento);
            $this->setPriceServiceDeclaredProductPrice($webServiceReturn->ValorValorDeclarado);
        }
    }

    /**
     * Returns if we need to return the price information regarding the delivery.
     *
     * @see Correios::$calculationTypes
     * @param string $calculationType Calculation type.
     * @return bool
     */
    private function returnsPrice($calculationType)
    {
        return ($calculationType == Correios::CALCULATION_TYPE_ALL_PRICE) ||
            ($calculationType == Correios::CALCULATION_TYPE_ONLY_PRICE) ||
            ($calculationType == Correios::CALCULATION_TYPE_ALL_PRICE_WITH_BASE_DATE) ||
            ($calculationType == Correios::CALCULATION_TYPE_ONLY_PRICE_WITH_BASE_DATE);
    }

    /**
     * Returns if we need to return the delivery information regarding the delivery.
     *
     * @see Correios::$calculationTypes
     * @param string $calculationType Calculation type.
     * @return bool
     */
    private function returnsDelivery($calculationType)
    {
        return ($calculationType == Correios::CALCULATION_TYPE_ALL_PRICE) ||
            ($calculationType == Correios::CALCULATION_TYPE_ONLY_DELIVERY) ||
            ($calculationType == Correios::CALCULATION_TYPE_ALL_PRICE_WITH_BASE_DATE) ||
            ($calculationType == Correios::CALCULATION_TYPE_ONLY_DELIVERY_WITH_BASE_DATE);
    }

    /**
     * Sets the service code.
     *
     * @see Correios::$services
     * @param string $serviceCode Service code.
     */
    private function setServiceCode($serviceCode)
    {
        $this->serviceCode = (string) $serviceCode;
    }

    /**
     * Sets the error code.
     *
     * @param string $errorCode Error code.
     */
    private function setErrorCode($errorCode)
    {
        $this->errorCode = (integer) $errorCode;
    }

    /**
     * Sets the error message.
     *
     * @param string $errorMessage Error message.
     */
    private function setErrorMessage($errorMessage)
    {
        $this->errorMessage = (string) $errorMessage;
    }

    /**
     * Sets the delivery days.
     *
     * @param string $deliveryDays Delivery days.
     */
    private function setDeliveryDays($deliveryDays)
    {
        $this->deliveryDays = (integer) $deliveryDays;
    }

    /**
     * Sets the information if the delivery service, delivery at home.
     *
     * @param string $deliveryAtHome Delivery at home.
     */
    private function setDeliveryAtHome($deliveryAtHome)
    {
        $this->deliveryAtHome = ($deliveryAtHome === 'S');
    }

    /**
     * Sets the information if the delivery service, delivery on saturday.
     *
     * @param string $deliveryOnSaturday Delivery on saturday.
     */
    private function setDeliveryOnSaturday($deliveryOnSaturday)
    {
        $this->deliveryOnSaturday = ($deliveryOnSaturday === 'S');
    }

    /**
     * Sets the total shipping price.
     *
     * @param string $price Shipping price.
     */
    private function setShippingPrice($price)
    {
        $this->shippingPrice = (float) str_replace(',', '.', $price);
    }

    /**
     * Sets the price of the additional service called "own hands".
     *
     * @param string $price Price of the service.
     */
    private function setPriceServiceOwnHands($price)
    {
        $this->priceServiceOwnHands = (float) str_replace(',', '.', $price);
    }

    /**
     * Sets the price of the additional service called "receipt notice".
     *
     * @param string $price Price of the service.
     */
    private function setPriceServiceReceiptNotice($price)
    {
        $this->priceServiceReceiptNotice = (float) str_replace(',', '.', $price);
    }

    /**
     * Sets the price of the additional service called "declared product price".
     *
     * @param string $price Price of the service.
     */
    private function setPriceServiceDeclaredProductPrice($price)
    {
        $this->priceServiceDeclaredProductPrice = (float) str_replace(',', '.', $price);
    }

    /**
     * Returns the service code.
     *
     * @return string
     */
    public function getServiceCode()
    {
        return sprintf("%'05s", $this->serviceCode);
    }

    /**
     * Returns the total shipping price.
     *
     * @return float
     */
    public function getShippingPrice()
    {
        return $this->shippingPrice;
    }

    /**
     * Returns the delivery days.
     *
     * @return integer
     */
    public function getDeliveryDays()
    {
        return $this->deliveryDays;
    }

    /**
     * Returns the price of the additional service called "own hands".
     *
     * @return float
     */
    public function getPriceServiceOwnHands()
    {
        return $this->priceServiceOwnHands;
    }

    /**
     * Returns the price of the additional service called "receipt notice".
     *
     * @return float
     */
    public function getPriceServiceReceiptNotice()
    {
        return $this->priceServiceReceiptNotice;
    }

    /**
     * Returns the price of the additional service called "declared product price".
     *
     * @return float
     */
    public function getPriceServiceDeclaredProductPrice()
    {
        return $this->priceServiceDeclaredProductPrice;
    }

    /**
     * Returns if the delivery service, delivery at home.
     *
     * @return boolean
     */
    public function getDeliveryAtHome()
    {
        return $this->deliveryAtHome;
    }

    /**
     * Returns if the delivery service, delivery on saturday.
     *
     * @return boolean
     */
    public function getDeliveryOnSaturday()
    {
        return $this->deliveryOnSaturday;
    }

    /**
     * Returns the error code.
     * If the error code is equals to zero, there is not error.
     *
     * @return integer
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Returns the error message.
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

}
