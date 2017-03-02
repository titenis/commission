<?php

namespace Commission\Entity;

/**
 * Class PaymentsCache
 *
 * @package Commission\Entity
 */
class PaymentsCache
{
    /**
     * @var array
     */
    private $cache = [];
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $year;
    /**
     * @var
     */
    private $week;

    /**
     * @return array
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param array $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param $amount
     */
    public function addToTotal($amount)
    {
        $userId = $this->getUserId();
        $year = $this->getYear();
        $week = $this->getWeek();

        if (empty($this->cache[$userId][$year][$week]['total'])) {
            $this->cache[$userId][$year][$week]['total'] = $amount;
        } else {
            $this->cache[$userId][$year][$week]['total'] += $amount;
        }
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * @param mixed $week
     */
    public function setWeek($week)
    {
        $this->week = $week;
    }

    /**
     *
     */
    public function incrementCount()
    {
        $userId = $this->getUserId();
        $year = $this->getYear();
        $week = $this->getWeek();

        if (empty($this->cache[$userId][$year][$week]['count'])) {
            $this->cache[$userId][$year][$week]['count'] = 1;
        } else {
            $this->cache[$userId][$year][$week]['count']++;
        }
    }

    /**
     * @param $amount
     * @return bool
     */
    public function totalIsLessThan($amount)
    {
        return $this->getTotal() < $amount;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        $userId = $this->getUserId();
        $year = $this->getYear();
        $week = $this->getWeek();

        return $this->cache[$userId][$year][$week]['total'];
    }

    /**
     * @param $count
     * @return bool
     */
    public function countDoesNotExceed($count)
    {
        return $this->getCount() <= $count;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        $userId = $this->getUserId();
        $year = $this->getYear();
        $week = $this->getWeek();

        return !isset($this->cache[$userId][$year][$week]['count']) ? 1 : $this->cache[$userId][$year][$week]['count'];
    }
}