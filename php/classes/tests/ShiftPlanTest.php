<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 6/27/2018
 * Time: 3:00 PM
 */

namespace Unm\Scheduler;
use function PHPSTORM_META\type;
use Unm\Scheduler\Tests\SchedulerTest;
require_once(dirname(__DIR__) . "/autoload.php");
require_once("SchedulerTest.php");


class ShiftPlanTest extends SchedulerTest
{
    protected $VALID_POD;

    public final function setUp() {
        $this->VALID_POD  = new Pod(null,"LOBO");
        $this->VALID_POD->insert($this->getPDO());
    }
    /**
     * test inserting a valid Pod and verify that the actual mySQL data matches
     **/
    public function testInsertValid() {
        $startDate = new \DateTime('2018-01-01T00:00:00.000000Z');
        $endDate = new \DateTime('2019-01-01T00:00:00.000000Z');
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("shiftPlan");
        // create a new Pod and insert to into mySQL
        $validPodId = $this->VALID_POD->getPodId();
        $shiftPlan = new ShiftPlan(null,$validPodId, $startDate, $endDate, "SPRING 2019");
        $shiftPlan->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoShiftPlan = ShiftPlan::getShiftPlanByName("Spring 2019");
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shiftPlan"));
        $this->assertEquals($pdoShiftPlan->getPodId(), $shiftPlan->getPodId());
        $this->assertEquals($pdoShiftPlan->getStartDate().$shiftPlan->getStartDate());
        $this->assertEquals(,);
    }

    /**
     * @expectedException \Exception
     */
    public function testInsertInvalid(){
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("pod");
        // create a new Pod and insert to into mySQL
        $pod = new Pod(67,$this->VALID_POD_NAME);
        $pod->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoPod = Pod::getPodByPodName($this->getPDO(), $pod->getPodName());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("pod"));
        $this->assertEquals($pdoPod->getPodId(), $pod->getPodId());
        $this->assertEquals($pdoPod->getPodName(), $this->VALID_POD_NAME);
    }

    public function testUpdateValid(){
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("pod");
        // create a new Pod and insert to into mySQL
        $pod = new Pod(null,$this->VALID_POD_NAME);
        $pod->insert($this->getPDO());
        $pod->setPodName("ATHLETICS");
        $pod->update($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoPod = Pod::getPodByPodName($this->getPDO(), $pod->getPodName());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("pod"));
        $this->assertEquals($pdoPod->getPodId(), $pod->getPodId());
        $this->assertEquals($pdoPod->getPodName(), "ATHLETICS");
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateInvalid(){
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("pod");
        // create a new Pod and insert to into mySQL
        $pod = new Pod(null,$this->VALID_POD_NAME);
        $pod->setPodName("ATHLETICS");
        $pod->update($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoPod = Pod::getPodByPodName($this->getPDO(), $pod->getPodName());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("pod"));
        $this->assertEquals($pdoPod->getPodId(), $pod->getPodId());
        $this->assertEquals($pdoPod->getPodName(), $this->VALID_POD_NAME);
    }

    public function testDeleteValid(){
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("pod");
        // create a new Pods and insert to into mySQL
        $pod = new Pod(null,$this->VALID_POD_NAME);
        $pod->insert($this->getPDO());
        // delete the Pod from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("pod"));
        $pod->delete($this->getPDO());
        // grab the data from mySQL and enforce the Pod does not exist
        $pdoPod = Pod::getPodByPodName($this->getPDO(), $pod->getPodName());
        $this->assertNull($pdoPod);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("pod"));
    }

    /**
     * @expectedException \Exception
     */
    public function testDeleteInValid(){
        $pod = new Pod(null, $this->VALID_POD_NAME);
        $pod->delete($this->getPDO());
    }



}