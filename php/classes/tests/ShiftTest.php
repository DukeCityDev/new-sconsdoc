<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 7/3/2018
 * Time: 9:30 AM
 */

namespace Unm\Scheduler;
use function PHPSTORM_META\type;
use Unm\Scheduler\Tests\SchedulerTest;
require_once(dirname(__DIR__) . "/autoload.php");
require_once("SchedulerTest.php");


class ShiftTest extends SchedulerTest
{
    protected $VALID_START_DATE;
    protected $VALID_END_DATE;
    protected $VALID_SCON;
    protected $VALID_SHIFTPLAN;
    protected $VALID_POD;
    public final function setUp() {
        $this->VALID_POD  = new Pod(null,"LOBO");
        $this->VALID_POD->insert($this->getPDO());
        $this->VALID_START_DATE = new \DateTime('2018-01-01T00:00:00.000000Z');
        $this->VALID_END_DATE = new \DateTime('2019-01-01T00:00:00.000000Z');
        $this->VALID_SCON = new Scon(null,"Daniel","Eaton","G","deaton747","deaton747@unm.edu","505-301-4618",$this->VALID_START_DATE,true);
        $this->VALID_SCON->insert($this->getPDO());
        $this->VALID_SHIFTPLAN = new ShiftPlan(null,$this->VALID_POD->getPodId(),$this->VALID_START_DATE,$this->VALID_END_DATE,"Summer 2018");
        $this->VALID_SHIFTPLAN->insert($this->getPDO());
    }

    /**
     * test inserting a valid Pod and verify that the actual mySQL data matches
     **/
    public function testInsertValid() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("shift");
        // create a new Pod and insert to into mySQL
        $validPodId = $this->VALID_POD->getPodId();
        $shift = new Shift(null,$this->VALID_SCON->getNetId(), $this->VALID_POD->getPodId(),$this->VALID_SHIFTPLAN->getShiftPlanId(),$this->VALID_START_DATE,$this->VALID_END_DATE, false);
        $shift->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoShift = Shift::getShiftById($this->getPDO(), $shift->getShiftId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shift"));
        $this->assertEquals($pdoShift->getSconNetId(), $shift->getSconNetId());
        $this->assertEquals($pdoShift->getShiftPlanId(), $shift->getShiftPlanId());
        $this->assertEquals($pdoShift->getPodId(), $shift->getPodId());
        $this->assertEquals($pdoShift->getStartDate(),$shift->getStartDate());
        $this->assertEquals($pdoShift->getEndDate(),$shift->getEndDate());
        $this->assertEquals($pdoShift->getAvailable(),$shift->getAvailable());
    }
}