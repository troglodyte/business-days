<?php

namespace troglodyte;

use troglodyte\Exceptions\BusinessDaysException;

class BusinessDays
{
    /**
     * @param $start_date
     * @param $end_date
     * @return int
     * @throws BusinessDaysException
     */
    public static function getBusinessDays($start_date, $end_date)
    {
        /** @var \DateTime $startDate */
        $startDate = self::convertDate($start_date);
        /** @var \DateTime $endDate */
        $endDate = self::convertDate($end_date);

        $difference = $startDate->diff($endDate);
        $number_of_full_weeks = floor($difference->days / 7);
        $number_of_remaining_days = fmod($difference->days, 7);
        $first_day_of_week = $startDate->format("N");
        $last_day_of_week = $endDate->format("N");

        // The two can be equal in leap years when february has 29 days, the equal sign is added here
        if ($first_day_of_week <= $last_day_of_week) {
            if ($first_day_of_week <= 6 && 6 <= $last_day_of_week) $number_of_remaining_days--;
            if ($first_day_of_week <= 7 && 7 <= $last_day_of_week) $number_of_remaining_days--;
        } else {
            if ($first_day_of_week == 7) {
                if ($last_day_of_week == 6) $number_of_remaining_days--;
            } else {
                $number_of_remaining_days -= 2;
            }
        }

        $workingDays = $number_of_full_weeks * 5;
        if ($number_of_remaining_days > 0) $workingDays += $number_of_remaining_days;
        $workingDays = floor($workingDays);
        return (int)$workingDays;
    }

    /**
     * @param $date
     * @return \DateTime
     * @throws BusinessDaysException
     */
    protected static function convertDate($date)
    {
        try {
            $date = new \DateTime($date);
            if ($date === false) throw new \Exception();
        } catch (\Exception $e) {
            throw new BusinessDaysException("Could not create date from date supplied: " . $date);
        }
        return $date;
    }

    /**
     * @param $target string
     * @return int
     * @throws BusinessDaysException
     */
    public static function getBusinessDaysFromNow($target)
    {
        $now_obj = new \DateTime('now');
        $start = (string)$now_obj->format('m/d/Y');
        $end = self::convertDate($target);
        if ($now_obj > $end) throw new BusinessDaysException("End date cannot be prior to start date");
        $distance = self::getBusinessDays($start, $target);
        return $distance;
    }

    /**
     * @param $start
     * @param $end
     * @return mixed
     * @throws BusinessDaysException
     */
    public static function getDiffInDays($start, $end)
    {
        $start = self::convertDate($start);
        $end = self::convertDate($end);
        $diff = $start->diff($end);
        return $diff->days;
    }

    /**
     * @param $target
     * @return mixed
     * @throws BusinessDaysException
     */
    public static function getDiffInDaysFromNow($target)
    {
        $target = self::convertDate($target);
        $now = new \DateTime('now');
        $diff = $now->diff($target);
        return $diff->days;
    }

    /**
     * @param string $start
     * @param $days_out int
     * @return \DateTime() date of $days_out from $start
     */
    public static function getBusinessDaysOut($start = 'now', $days_out)
    {
        $startObj =  new \DateTime($start);
        $targetObj = new \DateTime($start);
        $distanceObj = new \DateInterval('P' . $days_out . 'D');
        $targetObj->add($distanceObj);
        $actual_diff = self::getBusinessDays($startObj->format('m/d/Y'), $targetObj->format('m/d/Y'));
        if ($actual_diff < $days_out) {
            $diff = $days_out - $actual_diff;
            $targetObj->add(new \DateInterval('P' . $diff . 'D'));
        }
        return $targetObj;
    }
}


