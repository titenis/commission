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
}