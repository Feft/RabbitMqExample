<?php

namespace AppBundle\Domain;

/**
 * Calculating the highest common factor.
 * (in polish: największy wspólny podzielnik).
 */
class HighestCommonFactorCalculator
{
    /**
     * Calculate highest common factor of two numbers.
     * @see http://funkcje.net/view/2/3304/index.html
     *
     * @param $a mixed first value
     * @param $b mixed second value
     *
     * @return int highest common factor
     */
    public function calculate($a, $b)
    {
        $a = $this->normalizeArgument($a);
        $b = $this->normalizeArgument($b);

        while ($a !== $b) {
            if ($a < $b) {
                $helper = $a;
                $a = $b;
                $b = $helper;
            }
            $a = $a - $b;
        }
        return $a;
    }

    /**
     * Change type to integer.
     *
     * @param $arg mixed Value to normalizing
     *
     * @return integer
     */
    private function normalizeArgument($arg)
    {
        return (int)$arg;
    }
}