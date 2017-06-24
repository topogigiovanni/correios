<?php

/**
 * Class to calculate the delivery and price regarding Brazilian Postal Services called Correios.
 * Based on the 1.9 version of the API.
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 * @version 1.4
 * @see https://www.correios.com.br/para-voce/correios-de-a-a-z/calculador-remoto-de-precos-e-prazos-de-encomendas#tab-4
 * @final
 */

namespace correios\DeliveryAndPrice;

use correios\Correios;
use DateTime;
use Exception;
use SoapClient;
use SoapFault;
use stdClass;

final class CorreiosDeliveryAndPrice extends Correios
{

    /**
     * Contains the price type of calculation.
     *
     * @see Correios::$calculationTypes
     * @var string
     */
    private $calculationType = Correios::CALCULATION_TYPE_ALL_PRICE;

    /**
     * Contains the initiating zip code.
     *
     * @var string
     */
    private $initiatingZipCode;

    /**
     * Contains the receiving zip code.
     *
     * @var string
     */
    private $receivingZipCode;

    /**
     * Contains the package weight.
     *
     * @var float
     */
    private $packageWeight;

    /**
     * Contains the package shape.
     *
     * @see Correios::$packageShapes
     * @var integer
     */
    private $packageShape;

    /**
     * Contains the package length.
     *
     * @var float
     */
    private $packageLength;

    /**
     * Contains the package height.
     *
     * @var float
     */
    private $packageHeight;

    /**
     * Contains the package width.
     *
     * @var float
     */
    private $packageWidth;

    /**
     * Contains the package diameter.
     *
     * @var float
     */
    private $packageDiameter;

    /**
     * Contains if has the additional service called "own hands".
     *
     * @var boolean
     */
    private $hasOwnHandsService;

    /**
     * Contains the price for the additional service called "declared product price".
     *
     * @var float
     */
    private $hasDeclaredProductPriceService;

    /**
     * Contains the price for the additional service called "receipt notice".
     *
     * @var boolean
     */
    private $hasReceiptNoticeService;

    /**
     * Contains the base date for the calculation.
     *
     * @var DateTime
     */
    private $calculationDateBase;

    /**
     * Contains all the services used for the calculation.
     *
     * @see Correios::$services
     * @var array
     */
    private $usedServices = array();

    /**
     * Contains the return of the calculation.
     *
     * @var CorreiosDeliveryAndPriceResult[]
     */
    private $calculationReturns = array();

    /**
     * Creates an object to communicate with Correios API.
     *
     * @see Correios::$calculationTypes
     * @param string $user User.
     * @param string $password Password.
     * @param string $calculationType Calculation type.
     */
    public function __construct($user = '', $password = '', $calculationType = Correios::CALCULATION_TYPE_ALL_PRICE)
    {
        parent::__construct($user, $password);
        $this->setCalculationType($calculationType);
    }

    /**
     * Sets the calculation type.
     *
     * @see Correios::$calculationTypes
     * @param string $calculationType Calculation type.
     * @throws Exception
     */
    private function setCalculationType($calculationType)
    {
        if (in_array($calculationType, parent::$calculationTypes)) {
            $this->calculationType = $calculationType;
        } else {
            throw new Exception('The calculation type is invalid.');
        }
    }

    /**
     * Adds a service code to use in the calculation.
     *
     * @see Correios::$services
     * @param string $serviceCode Service code.
     * @throws Exception
     */
    public function addService($serviceCode)
    {
        if (in_array($serviceCode, parent::$services)) {
            $this->usedServices[] = $serviceCode;
        } else {
            throw new Exception('The service code is invalid.');
        }
    }

    /**
     * Sets the initiating zip code of the delivery.
     *
     * @param string $initiatingZipCode Initiating Zip Code.
     */
    public function setInitiatingZipCode($initiatingZipCode)
    {
        $this->initiatingZipCode = $initiatingZipCode;
    }

    /**
     * Sets the receiving zip code of the delivery.
     *
     * @param string $receivingZipCode Receiving Zip Code.
     */
    public function setReceivingZipCode($receivingZipCode)
    {
        $this->receivingZipCode = $receivingZipCode;
    }

    /**
     * Sets the weight of the package in kilograms.
     *
     * @param float $packageWeight Weight of the package.
     * @throws Exception
     */
    public function setPackageWeight($packageWeight)
    {
        if (is_float($packageWeight)) {
            $this->packageWeight = $packageWeight;
        } else {
            throw new Exception('The weight is invalid.');
        }
    }

    /**
     * Sets the shape of the package.
     *
     * @param integer $packageShape Shape of the package.
     * @throws Exception
     */
    public function setPackageShape($packageShape)
    {
        if (in_array($packageShape, parent::$packageShapes)) {
            $this->packageShape = $packageShape;
        } else {
            throw new Exception('The shape of the package is invalid.');
        }
    }

    /**
     * Sets the length of package in centimeters.
     *
     * @param float $packageLength Length of the package.
     * @throws Exception
     */
    public function setPackageLength($packageLength)
    {
        if (is_float($packageLength)) {
            $this->packageLength = $packageLength;
        } else {
            throw new Exception('The length of the package is invalid.');
        }
    }

    /**
     * Sets the height of the package in centimeters.
     *
     * @param float $packageHeight Height of the package.
     * @throws Exception
     */
    public function setPackageHeight($packageHeight)
    {
        if (is_float($packageHeight)) {
            $this->packageHeight = $packageHeight;
        } else {
            throw new Exception('The height of the package is invalid.');
        }
    }

    /**
     * Sets the width of the package in centimeters.
     *
     * @param float $packageWidth Width of the package.
     * @throws Exception
     */
    public function setPackageWidth($packageWidth)
    {
        if (is_float($packageWidth)) {
            $this->packageWidth = $packageWidth;
        } else {
            throw new Exception('The width of the package is invalid.');
        }
    }

    /**
     * Sets the diameter of the package in centimeters.
     *
     * @param float $packageDiameter Diameter of the package.
     * @throws Exception
     */
    public function setPackageDiameter($packageDiameter)
    {
        if (is_float($packageDiameter)) {
            $this->packageDiameter = $packageDiameter;
        } else {
            throw new Exception('The diameter of the package is invalid.');
        }
    }

    /**
     * Sets if the package will be delivered with the additional service called "Own Hands".
     *
     * @param boolean $ownHandsService Has own hands service.
     * @throws Exception
     */
    public function hasOwnHandsService($ownHandsService)
    {
        if (is_bool($ownHandsService)) {
            $this->hasOwnHandsService = $ownHandsService;
        } else {
            throw new Exception('The additional service called "Own Hands" is invalid.');
        }
    }

    /**
     * Sets if the package will be delivered with the additional service called "Declared Product Price".
     *
     * @param float $declaredProductPriceService Has declared product price service.
     * @throws Exception
     */
    public function setDeclaredProductPriceService($declaredProductPriceService)
    {
        if (is_float($declaredProductPriceService)) {
            $this->hasDeclaredProductPriceService = $declaredProductPriceService;
        } else {
            throw new Exception('The price to additional service called "Declared Product" is invalid.');
        }
    }

    /**
     * Sets if the package will be delivered with the additional service called "Receipt Notice".
     *
     * @param boolean $receiptNoticeService Has receipt notice service.
     * @throws Exception
     */
    public function hasReceiptNoticeService($receiptNoticeService)
    {
        if (is_bool($receiptNoticeService)) {
            $this->hasReceiptNoticeService = $receiptNoticeService;
        } else {
            throw new Exception('The additional service called "Receipt Notice" is invalid.');
        }
    }

    /**
     * Returns the calculation type.
     *
     * @see Correios::$calculationTypes
     * @return string
     */
    public function getCalculationType()
    {
        return $this->calculationType;
    }

    /**
     * Returns the calculation date base.
     *
     * @return DateTime
     */
    public function getCalculationDateBase()
    {
        return $this->calculationDateBase;
    }

    /**
     * Sets the calculation date base.
     *
     * @param DateTime $calculationDateBase Calculation date base.
     */
    public function setCalculationDateBase(DateTime $calculationDateBase)
    {
        $this->calculationDateBase = $calculationDateBase;
    }

    /**
     * Returns the calculation return.
     *
     * @return CorreiosDeliveryAndPriceResult[]
     */
    public function getCalculationReturn()
    {
        return $this->calculationReturns;
    }

    /**
     * Process the calculation and stores the results.
     *
     * @return boolean
     * @throws Exception
     */
    public function process()
    {
        $this->checkConnection();
        $methods = $this->getWebserviceMethods();

        try {
            //Gets the webservice return
            $return = $this->requestData($methods['consultation']);
            $returnMethod = $methods['return'];

            //Threats the returns
            if ($return instanceof stdClass) {
                $this->processReturn($return->$returnMethod->Servicos->cServico);
                return TRUE;
            }

            return FALSE;
        } catch (SoapFault $sf) {
            throw new Exception($sf->getMessage());
        }
    }

    /**
     * Checks if there connection with the Correios webservice.
     *
     * @throws Exception
     */
    private function checkConnection()
    {
        ini_set("allow_url_fopen", 1);
        ini_set("soap.wsdl_cache_enabled", 0);

        if (!@fopen(parent::URL_CALCULADOR, 'r')) {
            throw new Exception('There is no connection with Correios webservice. Try again later.');
        }
    }

    /**
     * Returns the methods to use into webservice.
     *
     * @see Correios::$calculationTypes
     * @return array
     */
    private function getWebserviceMethods()
    {
        $data = parent::$deliveryPriceMethods;

        return array(
            'consultation' => $data[$this->calculationType]['consultation'],
            'return' => $data[$this->calculationType]['return']
        );
    }

    /**
     * Request data from Correios webservice.
     *
     * @param String $consultationMethod Name of the method used to request werbservice data.
     * @return stdClass
     */
    private function requestData($consultationMethod)
    {
        //Create a SOAP client
        $soap = new SoapClient(parent::URL_CALCULADOR);

        //Gets the returns
        return $soap->$consultationMethod($this->getParameters());

    }

    /**
     * Returns the necessary parameters to consultation.
     *
     * @return array
     */
    protected function getParameters()
    {
        if ($this->isOnlyDelivery()) {
            $parameters = $this->getOnlyDeliveryParameters();
        } else {
            $parameters = $this->getAllParameters();
        }
        //If the need to consider the date base
        if ($this->hasDateBase()) {
            $parameters['sDtCalculo'] = (string) $this->calculationDateBase->format('d/m/Y');
        }
        return $parameters;
    }

    /**
     * Returns if the calculation needs to consider only delivery.
     *
     * @see Correios::$calculationTypes
     * @return bool
     */
    private function isOnlyDelivery()
    {
        return ($this->calculationType == Correios::CALCULATION_TYPE_ONLY_DELIVERY) ||
            ($this->calculationType == Correios::CALCULATION_TYPE_ONLY_DELIVERY_WITH_BASE_DATE);
    }

    /**
     * Returns the parameters only for delivery calculation.
     *
     * @return array
     */
    private function getOnlyDeliveryParameters()
    {
        return array(
            'nCdServico' => (string) $this->getServices(),
            'sCepOrigem' => (string) $this->initiatingZipCode,
            'sCepDestino' => (string) $this->receivingZipCode,
        );

    }

    /**
     * Returns all the services used for the calculation.
     *
     * @return string
     */
    private function getServices()
    {
        $services = implode(',', $this->usedServices);
        return $services;
    }

    /**
     * Returns all the parameters.
     *
     * @return array
     */
    private function getAllParameters()
    {
        return array(
            'nCdEmpresa' => (string) $this->getUsuario(),
            'sDsSenha' => (string) $this->getSenha(),
            'nCdServico' => (string) $this->getServices(),
            'sCepOrigem' => (string) $this->initiatingZipCode,
            'sCepDestino' => (string) $this->receivingZipCode,
            'nVlPeso' => (float) $this->packageWeight,
            'nCdFormato' => (integer) $this->packageShape,
            'nVlComprimento' => (float) $this->packageLength,
            'nVlAltura' => (float) $this->packageHeight,
            'nVlLargura' => (float) $this->packageWidth,
            'nVlDiametro' => (float) $this->packageDiameter,
            'sCdMaoPropria' => (string) $this->hasOwnHandsService ? 'S' : 'N',
            'nVlValorDeclarado' => (float) $this->hasDeclaredProductPriceService,
            'sCdAvisoRecebimento' => (string) $this->hasReceiptNoticeService ? 'S' : 'N',
        );
    }

    /**
     * Returns if the calculation has date base.
     *
     * @see Correios::$calculationTypes
     * @return bool
     */
    private function hasDateBase()
    {
        return ($this->calculationType == Correios::CALCULATION_TYPE_ONLY_DELIVERY_WITH_BASE_DATE) ||
            ($this->calculationType == Correios::CALCULATION_TYPE_ONLY_PRICE_WITH_BASE_DATE) ||
            ($this->calculationType == Correios::CALCULATION_TYPE_ALL_PRICE_WITH_BASE_DATE);
    }

    /**
     * Do the process to treat the return of the webservice.
     * This method prepare the return to put the thing on the correct objects.
     *
     * @param $returns Webservice returns.
     */
    private function processReturn($returns)
    {
        if (is_array($returns)) {
            foreach ($returns as $return) {
                $this->calculationReturns[] = new CorreiosDeliveryAndPriceResult($return, $this->calculationType);
            }
        } else if ($returns instanceof stdClass) {
            $this->calculationReturns[] = new CorreiosDeliveryAndPriceResult($returns, $this->calculationType);
        }
    }

}
