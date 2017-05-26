<?php

/**
 * A simple example of SRO data information.
 * SRO is a acronym to Serviço de Rastreamento de Objetos (Brazilian Postal Object Tracking Service).
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 * @version 1.5
 */

namespace correios\examples;

require __DIR__ . '/../vendor/autoload.php';

use correios\Sro\CorreiosSro;
use correios\Sro\CorreiosSroData;

//Adjust the text content-type to UTF-8 return
header('Content-type: text/txt; charset=utf-8');

try {
    echo '======================' . PHP_EOL;
    echo 'SRO Validation Example' . PHP_EOL;
    echo '======================' . PHP_EOL;

    echo 'SRO....: SW592067296BR' . PHP_EOL;
    echo 'Valid..: ' . ((CorreiosSro::validateSro('SW592067296BR')) ? 'Yes' : 'No') . PHP_EOL . PHP_EOL;
} catch (\Exception $ex) {
    echo 'An error occurred: ' . $ex->getMessage() . PHP_EOL . PHP_EOL;
}


try {
    $objectData = new CorreiosSroData('SW592067296BR');
    echo '================' . PHP_EOL;
    echo 'SRO Data Example' . PHP_EOL;
    echo '================' . PHP_EOL;

    echo 'SRO...................: ' . $objectData->getCode() . PHP_EOL;
    echo 'Service Acronym.......: ' . $objectData->getServiceAcronym() . PHP_EOL;
    echo 'Service Description...: ' . $objectData->getServiceDescription() . PHP_EOL;
    echo 'Object Code...........: ' . $objectData->getObjectCode() . PHP_EOL;
    echo 'SRO Digit.............: ' . $objectData->getDigit() . PHP_EOL;
    echo 'Origin Country........: ' . $objectData->getOriginCountry() . PHP_EOL . PHP_EOL;
} catch (\Exception $ex) {
    echo 'An error occurred: ' . $ex->getMessage() . PHP_EOL . PHP_EOL;
}

try {
    echo '============================' . PHP_EOL;
    echo 'SRO Digit Generation Example' . PHP_EOL;
    echo '============================' . PHP_EOL;

    echo 'SRO Code..: 59206729' . PHP_EOL;
    echo 'SRO Digit.: ' . CorreiosSro::calculateSroDigit('59206729') . PHP_EOL . PHP_EOL;
} catch (\Exception $ex) {
    echo 'An error occurred: ' . $ex->getMessage() . PHP_EOL . PHP_EOL;
}
