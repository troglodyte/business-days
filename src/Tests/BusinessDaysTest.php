<?php
namespace troglodyte\Tests;

use troglodyte\BusinessDays;

class BusinessDaysTest extends \PHPUnit_Framework_TestCase
{
    /** @var BusinessDays */
    protected $dt;

    public function setup()
    {
        $this->dt = new BusinessDays();
    }

    public function testCanCreateObj()
    {
        $this->assertInstanceOf('troglodyte\BusinessDays', $this->dt);
    }

    public function testCanFailIfGivenCrappyDate()
    {
        $date = 'just another crappy date';
        $this->setExpectedException('troglodyte\Exceptions\BusinessDaysException', "Could not create date from date supplied: " . $date);
        $this->dt->getBusinessDays($date, '11/12/2014');
    }

    public function testCanGetTwoDaysDifference()
    {
        $wd = $this->dt->getBusinessDays('11/10/2014','11/12/2014');
        $this->assertSame(2, $wd);
    }

    public function testCanGetWeekAndAHalfWorkingDaysDifference()
    {
        $wd = $this->dt->getBusinessDays('11/6/2014','11/18/2014');
        $this->assertSame(8, $wd);
    }

    public function testCanRemoveWeekendInBetween()
    {
        $wd = $this->dt->getBusinessDays('11/13/2014','11/17/2014');
        $this->assertSame(2, $wd);
    }

    public function testCanRemoveSevenDayWeek()
    {
        $wd = $this->dt->getBusinessDays('11/01/2014','11/08/2014');
        $this->assertSame(5, $wd);
    }

    public function testCanGet5BusDaysFromSunToSatPeriod()
    {
        $wd = $this->dt->getBusinessDays('11/02/2014','11/08/2014');
        $this->assertSame(5, $wd);
    }

    public function testCanGet2WeeksworkingDays()
    {
        $wd = $this->dt->getBusinessDays('11/09/2014','11/22/2014');
        $this->assertSame(10, $wd);
    }

    public function testCanCalculateAllWorkingDaysInMonth()
    {
        $wd = $this->dt->getBusinessDays('11/01/2014','11/30/2014');
        $this->assertSame(20, $wd);
    }

    public function testCanCalculateWorkingDaysDistanceInNonWeekendStartingMonth()
    {
        $wd = $this->dt->getBusinessDays('10/01/2014','10/31/2014');
        $this->assertSame(22, $wd);
    }

    public function testCanCalculateWorkingDaysDistanceIn2Months()
    {
        $wd = $this->dt->getBusinessDays('11/01/2014','12/31/2014');
        $this->assertSame(42, $wd);
    }

    public function testCanFlagWithinThreeDaysFromNow()
    {
        $now_obj = new \DateTime('now');
        $now_obj->add(new \DateInterval('P2D'));
        $soon = (string)$now_obj->format('m/d/Y');
        $wd = $this->dt->getBusinessDaysFromNow($soon);
        $this->assertSame(2,$wd);
    }

    public function testCanGetDiffInDays()
    {
        $d = $this->dt->getRawDiffInDays('11/01/2014', '11/3/2014');
        $this->assertSame(2,$d);
    }

    public function testCanGetDiffInDaysFromNow()
    {
        $target = new \DateTime('now');
        $target->add(new \DateInterval('P2D'));
        $target = $target->format('m/d/Y');
        $d = $this->dt->getBusinessDaysFromNow($target);
        $this->assertSame(2,$d);
    }

    public function testCanGetThreeBusinessDaysOut()
    {
        $days_out = 3;
        $start = '12/15/2014';
        $expected = '12/18/2014';
        $result = $this->dt->getBusinessDaysOut($start, $days_out);
        $this->assertInstanceOf('DateTime', $result);
        $formatted_result = $result->format('m/d/Y');
        $this->assertSame($formatted_result, $expected);
    }

    public function testCanGetThreeBusinessDaysOutOverWeekend()
    {
        $days_out = 3;
        $start = '12/19/2014';
        $expected = '12/24/2014';
        $result = $this->dt->getBusinessDaysOut($start, $days_out);
        $this->assertInstanceOf('DateTime', $result);
        $formatted_result = $result->format('m/d/Y');
        $this->assertSame($formatted_result, $expected);
    }
}