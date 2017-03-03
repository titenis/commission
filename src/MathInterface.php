<?php

namespace Commission;

/**
 * Interface MathInterface
 *
 * @package Commission
 */
interface MathInterface
{
    /**
     * @param $left
     * @param $right
     * @param $scale
     * @return mixed
     */
    public function sub($left, $right, $scale = 0);

    /**
     * @param $left
     * @param $right
     * @param $scale
     * @return mixed
     */
    public function add($left, $right, $scale = 0);

    /**
     * @param $left
     * @param $right
     * @param $scale
     * @return mixed
     */
    public function div($left, $right, $scale = 0);

    /**
     * @param $left
     * @param $right
     * @param $scale
     * @return mixed
     */
    public function mul($left, $right, $scale = 0);

    /**
     * @param $left
     * @param $right
     * @param $scale
     * @return mixed
     */
    public function pow($left, $right, $scale = 0);

    /**
     * @param     $number
     * @param int $decimal
     * @return mixed
     */
    public function formatAndRound($number, $decimal = 2);

    /**
     * @param      $amount
     * @param      $percentage
     * @param null $min
     * @param null $max
     * @return mixed
     */
    public function calculateByPercentage($amount, $percentage, $min = null, $max = null);
}