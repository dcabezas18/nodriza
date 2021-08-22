<?php

namespace App\Tests\Controller;

use App\Validator\PlanetValidator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PlanetValidatorTest extends KernelTestCase
{
    public function testPlanetValidator(): void
    {
        //Input type error
        $input = array(
            'id' => 1,
            'name' => 'asd',
            'rotation_period' => '',
            'orbital_period' => 1,
            'diameter' => 1
        );
        $validator = new PlanetValidator();
        $isValid = $validator->postValidate($input);
        $this->assertEquals(
            '[rotation_period] This value should be positive.',
            $isValid[0]
        );
        //Extra input param error
        $input = array(
            'id' => 1,
            'name' => 'asd',
            'rotation_period' => 1,
            'orbital_period' => 1,
            'diameter' => 1,
            'asd' => 'asd'
        );
        $validator = new PlanetValidator();
        $isValid = $validator->postValidate($input);
        $this->assertEquals(
            '[asd] This field was not expected.',
            $isValid[0]
        );

        //Only required params
        $input = array(
            'id' => 1,
            'name' => 'asd'
        );
        $validator = new PlanetValidator();
        $isValid = $validator->postValidate($input);
        $this->assertEmpty($isValid);

        //All params
        $input = array(
            'id' => 1,
            'name' => 'asd',
            'rotation_period' => 1,
            'orbital_period' => 1,
            'diameter' => 1
        );
        $validator = new PlanetValidator();
        $isValid = $validator->postValidate($input);
        $this->assertEmpty($isValid);
    }
}