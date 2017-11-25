<?php

namespace Tests\AppBundle\Domain;

use AppBundle\Domain\HighestCommonFactorCalculator;
use PHPUnit\Framework\TestCase;

class HighestCommonFactorCalculatorTest extends TestCase
{
    /**
     * @param $firstNumber int first number to calculate HCF
     * @param $secondNumber int second number to calculate HCF
     * @param $expectedResult int expected result of highest common factor calculations
     *
     * @dataProvider correctNumbersProvider
     */
    public function testCorrectNumbers($firstNumber, $secondNumber, $expectedResult)
    {
        $hcfCalculator = new HighestCommonFactorCalculator();
        $result = $hcfCalculator->calculate($firstNumber, $secondNumber);
        $this->assertEquals($expectedResult, $result);
    }

    public function correctNumbersProvider()
    {
        return array(
            array(2, 8, 2),
            array(4, 10, 2),
            array(4, 3, 1),
            array(10, 32, 2),
            array(30, 105, 15),
            array(225, 1545, 15),
            array(381, 723, 3),
            array(488, 496, 8),
        );
    }

    /**
     * @dataProvider wrongNumbersProvider
     */
    public function testWrongNumbers($firstNumber, $secondNumber, $expectedResult)
    {
        $hcfCalculator = new HighestCommonFactorCalculator();
        $result = $hcfCalculator->calculate($firstNumber, $secondNumber);
        $this->assertFalse($expectedResult === $result);
    }

    public function wrongNumbersProvider()
    {
        return array(
            array(2, 8, 3),
            array(4, 10, 4),
            array(4, 3, 2),
            array(10, 32, 5),
            array(30, 105, 7),
            array(225, 1545, 159),
            array(381, 723, 2),
            array(488, 496, 9),
        );
    }


}
