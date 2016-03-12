<?php 

namespace correios\Sro;

use correios\Sro\CorreiosSro;

 class CorreiosSroTest extends \PHPUnit_Framework_TestCase {

 	public function testValidaSroTrue() {
 		$this->assertEquals(true, CorreiosSro::validaSro('SW592067296BR'));
 	}

 	public function testValidaSroFalse() {
 		$this->assertEquals(false, CorreiosSro::validaSro('SW00000000BR'));
 	}

}