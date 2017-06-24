<?php

/**
 * A small example showing how to use the API do calculate the delivery and price of an
 * tracking number.
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 * @version 1.4
 */

namespace Examples;

require __DIR__ . '/../vendor/autoload.php';

use correios\Correios;
use correios\DeliveryAndPrice\CorreiosDeliveryAndPrice;
use DateTime;
use Exception;

//Sets the encode that your application needs to use
header('Content-type: text/txt; charset=utf-8');

//Set the timezone that your application needs to use
date_default_timezone_set('America/Sao_Paulo');

try
{
    //Creates an object and define if you need delivery and price information.
    //On this version, is possible to define only price or only delivery.

    $calculation = new CorreiosDeliveryAndPrice('ECT', 'ECT', Correios::CALCULATION_TYPE_ALL_PRICE);
    //Sent the parameters
    $calculation->setInitiatingZipCode('89050100');
    $calculation->setReceivingZipCode('89010130');
    $calculation->addService(Correios::SERVICE_PAC_WITHOUT_CONTRACT_AGENCY);
    $calculation->setPackageShape(Correios::PACKAGE_SHAPE_BOX_PARCEL);
    $calculation->setPackageWeight(9.56);
    $calculation->setDeclaredProductPriceService(637.89);
    $calculation->hasOwnHandsService(FALSE);
    $calculation->hasReceiptNoticeService(TRUE);
    $calculation->setPackageHeight(2.0);
    $calculation->setPackageWidth(11.0);
    $calculation->setPackageLength(16.0);
    //Use this method only if you want to set a different date base.
    //The default is today.
    $calculation->setCalculationDateBase(new DateTime('03/03/2018'));
    //Process the information. This is mandatory.
    if ($calculation->process())
    {
        foreach ($calculation->getCalculationReturn() as $return)
        {
            //If didn't have error
            if ($return->getErrorCode() === 0)
            {
                echo 'Service.....................................: ' . $return->getServiceCode() . ' (' . Correios::$serviceName[$return->getServiceCode()] . ')' . PHP_EOL;
                if ($calculation->getCalculationDateBase() instanceof DateTime)
                {
                    echo 'Date base of the calculation................: ' . $calculation->getCalculationDateBase()->format('d/m/Y') . PHP_EOL;
                }
                if (($calculation->getCalculationType() == Correios::CALCULATION_TYPE_ALL_PRICE) ||
                    ($calculation->getCalculationType() == Correios::CALCULATION_TYPE_ONLY_DELIVERY) ||
                    ($calculation->getCalculationType() == Correios::CALCULATION_TYPE_ALL_PRICE_WITH_BASE_DATE) ||
                    ($calculation->getCalculationType() == Correios::CALCULATION_TYPE_ONLY_DELIVERY_WITH_BASE_DATE)
                )
                {
                    $deliveryAtHome = $return->getDeliveryAtHome() ? 'Yes' : 'No';
                    $deliveryOnSaturdays = $return->getDeliveryOnSaturday() ? 'Yes' : 'No';
                    echo 'Delivery days...............................: ' . $return->getDeliveryDays() . PHP_EOL;
                    echo 'Delivery at home............................: ' . $deliveryAtHome . PHP_EOL;
                    echo 'Delivery on Saturdays.......................: ' . $deliveryOnSaturdays . PHP_EOL;
                }
                if (($calculation->getCalculationType() == Correios::CALCULATION_TYPE_ALL_PRICE) ||
                    ($calculation->getCalculationType() == Correios::CALCULATION_TYPE_ONLY_PRICE) ||
                    ($calculation->getCalculationType() == Correios::CALCULATION_TYPE_ALL_PRICE_WITH_BASE_DATE) ||
                    ($calculation->getCalculationType() == Correios::CALCULATION_TYPE_ONLY_PRICE_WITH_BASE_DATE)
                )
                {
                    echo 'Price.......................................: R$ ' . number_format($return->getShippingPrice(), 2, ',', '.') . PHP_EOL;
                    echo 'Price of the service own hands..............: R$ ' . number_format($return->getPriceServiceOwnHands(), 2, ',', '.') . PHP_EOL;
                    echo 'Price of the service receipt notice.........: R$ ' . number_format($return->getPriceServiceReceiptNotice(), 2, ',', '.') . PHP_EOL;
                    echo 'Price of the service declared product price.: R$ ' . number_format($return->getPriceServiceDeclaredProductPrice(), 2, ',', '.') . PHP_EOL;
                }
                echo PHP_EOL;
            } else
            {
                echo 'An error occurred in the calculation of the service ' . $return->getServiceCode() . ' (' . Correios::$serviceName[$return->getServiceCode()] . '): ' . $return->getErrorMessage() . PHP_EOL . PHP_EOL;
            }
        }
    } else
    {
        echo 'An error occurred. Try again later.' . PHP_EOL;
    }
} catch (Exception $e)
{
    echo 'An error occurred. Error: ' . $e->getMessage() . PHP_EOL;
}
