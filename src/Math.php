<?php

namespace Commission;

/**
 * Class Math
 *
 * @package Commission
 */
class Math implements MathInterface
{
    /**
     * @param      $amount
     * @param      $percentage
     * @param null $min
     * @param null $max
     * @return float|null
     */
    public function calculateByPercentage($amount, $percentage, $min = null, $max = null)
    {
        $result = $this->div($this->mul($amount, $percentage), 100);

        if (isset($max) && $result > $max) {
            $result = $max;
        }

        if (isset($min) && $result < $min) {
            $result = $min;
        }

        return $result;
    }

    /**
     * @param     $left
     * @param     $right
     * @param int $scale
     * @return string
     */
    public function div($left, $right, $scale = 3)
    {
        return bcdiv($left, $right, $scale);
    }

    /**
     * @param     $left
     * @param     $right
     * @param int $scale
     * @return string
     */
    public function mul($left, $right, $scale = 3)
    {
        return bcmul($left, $right, $scale);
    }

    /**
     * @param     $number
     * @param int $decimal
     * @return string
     */
    public function formatAndRound($number, $decimal = 2)
    {
        return number_format($this->roundUp($number, $decimal), $decimal);
    }

    /**
     * @param     $number
     * @param int $precision
     * @return float
     */
    public function roundUp($number, $precision = 2)
    {
        $fig = $this->pow(10, $precision);

        return $this->div(ceil($this->mul($number, $fig)), $fig);
    }

    /**
     * @param     $left
     * @param     $right
     * @param int $scale
     * @return string
     */
    public function pow($left, $right, $scale = 3)
    {
        return bcpow($left, $right, $scale);
    }

    /**
     * @param     $left
     * @param     $right
     * @param int $scale
     * @return string
     */
    public function add($left, $right, $scale = 3)
    {
        return bcadd($left, $right, $scale);
    }

    /**
     * @param     $left
     * @param     $right
     * @param int $scale
     * @return string
     */
    public function sub($left, $right, $scale = 3)
    {
        return bcsub($left, $right, $scale);
    }
}