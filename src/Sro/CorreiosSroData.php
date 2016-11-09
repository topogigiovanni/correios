<?php

/**
 * This class help us to understand all the information about a SRO number.
 * SRO is a acronym to Serviço de Rastreamento de Objetos (Brazilian Postal Object Tracking Service).
 *
 * @author Ivan Wilhelm <ivan.whm@me.com>
 * @version 1.5
 * @final
 */

namespace correios\Sro;

final class CorreiosSroData extends CorreiosSro
{

    /**
     * This is the SRO code.
     *
     * @var string
     */
    private $code;

    /**
     * Provide the service acronym about a SRO number.
     * A service is like an option that you can send your objects.
     *
     * @var string
     */
    private $serviceAcronym;

    /**
     * Provide the service description about a SRO number.
     * A service is like an option that you can send your objects.
     *
     * @var string
     */
    private $serviceDescription;

    /**
     * Provide an object code from a SRO number.
     *
     * @var string
     */
    private $objectCode;

    /**
     * Provide a digit from a SRO number.
     *
     * @var string
     */
    private $digit;

    /**
     * Provide the ISO2 acronym about the origin country of the SRO number.
     *
     * @var string
     */
    private $originCountry;

    /**
     * Create a new SRO data object.
     *
     * @param string $sro SRO number.
     * @throws \Exception
     */
    public function __construct($sro)
    {
        if ($this->validateSro($sro))
        {
            $this->code = $sro;
            $this->serviceAcronym = substr($sro, 0, 2);
            $this->serviceDescription = self::$sroAcronymsWithDescription[substr($sro, 0, 2)];
            $this->objectCode = substr($sro, 2, 8);
            $this->digit = substr($sro, 10, 1);
            $this->originCountry = substr($sro, 11, 2);
        } else
        {
            throw new \Exception('SRO number is invalid.');
        }
    }

    /**
     * Return the SRO code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Return the service acronym about the SRO number.
     *
     * @return string
     */
    public function getServiceAcronym()
    {
        return $this->serviceAcronym;
    }

    /**
     * Return the service description (in Portuguese) about the SRO number.
     * @return string
     */
    public function getServiceDescription()
    {
        return $this->serviceDescription;
    }

    /**
     * Return the object code about the SRO number.
     *
     * @return string
     */
    public function getObjectCode()
    {
        return $this->objectCode;
    }

    /**
     * Return the digit about the SRO number.
     *
     * @return string
     */
    public function getDigit()
    {
        return $this->digit;
    }

    /**
     * Return the ISO2 origin country about the SRO number.
     *
     * @return string
     */
    public function getOriginCountry()
    {
        return $this->originCountry;
    }

}
