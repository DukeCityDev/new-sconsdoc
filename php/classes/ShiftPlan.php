<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 6/26/2018
 * Time: 12:51 PM
 */

namespace Unm\Scheduler;
require_once(dirname(__DIR__) . "/autoload.php");
require_once(dirname(__DIR__) . "/util/Util.php");


class ShiftPlan
{
//      shiftPlanId INT UNSIGNED AUTO_INCREMENT,
//    podId INT UNSIGNED NOT NULL,
//    startDate DATETIME NOT NULL,
//    endDate DATETIME NOT NULL,
//    shiftPlanName VARCHAR(20),


    private $shiftPlanId;
    private $podId;
    private $startDate;
    private $endDate;
    private $shiftPlanName;

    public function __construct(?int $shiftPlanId,int $podId, \DateTime $startDate, \DateTime $endDate, string $shiftPlanName)
    {
        try{
            $this->setShiftPlanId($shiftPlanId);
            $this->setPodId($podId);
            $this->setStartDate($startDate);
            $this->setEndDate($endDate);
            $this->setShiftPlanName($shiftPlanName);
        } catch(\InvalidArgumentException $invalidArgument) {
            throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
        } catch(\RangeException $range) {
            throw(new \RangeException($range->getMessage(), 0, $range));
        } catch(\TypeError $typeError) {
            throw(new \TypeError($typeError->getMessage(), 0, $typeError));
        } catch(\Exception $exception) {
            throw(new \Exception($exception->getMessage(), 0, $exception));
        }
    }

    public function setShiftPlanId(?int $shiftPlanId):void{
        if(!is_null($shiftPlanId)){

            if(!is_int($shiftPlanId)){
                throw new \InvalidArgumentException("ShiftPlan Id is Invalid: Not An Integer");
            } else if($shiftPlanId < 0){
                throw new \InvalidArgumentException("ShiftPlan Id is Invalid: Negative Integer");
            } else if($shiftPlanId >= 4294967296){
                throw new \OutOfBoundsException("ShiftPlan ID is Invalid: Maximum INT(10) Size, assign more bytes to Shift Plan Id");
            }
        }
        $this->shiftPlanId = $shiftPlanId;
    }

    /**
     * @return mixed
     */
    public function getShiftPlanId(): ?int
    {
        return $this->shiftPlanId;
    }

    public function setPodId(int $podId){

            if(!is_int($podId)){
                throw new \InvalidArgumentException("Pod Id is Invalid: Not An Integer");
            } else if($podId < 0){
                throw new \InvalidArgumentException("Scon Id is Invalid: Negative Integer");
            } else if($podId >= 4294967296){
                throw new \OutOfBoundsException("Pod ID is Invalid: Maximum INT(10) Size, assign more bytes to ShiftPlan  PodId");
            }

        $this->podId = $podId;
    }

    /**
     * @return int
     */
    public function getPodId():int
    {
        return $this->podId;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate)
    {
        if(is_null($startDate)){
            throw new \InvalidArgumentException("ShiftPlan Start Date is not Valid DateTime");
        }
        if(!Util::verifyDate($startDate)){
            throw new \InvalidArgumentException("ShiftPlan Start Date is not Valid DateTime");
        }
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate)
    {
        if(is_null($endDate)){
            throw new \InvalidArgumentException("ShiftPlan End Date is not Valid DateTime");
        }
        if(!Util::verifyDate($endDate)){
            throw new \InvalidArgumentException("ShiftPlan End Date is not Valid Datetime");
        }
        $this->endDate = $endDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate() :\DateTime
    {
        return $this->endDate;
    }

    public function setShiftPlanName(string $shiftPlanName){
        if(is_null($shiftPlanName)){
            $shiftPlanName = "";
        }
        if(!is_string($shiftPlanName)){
            throw new \TypeError("Shift Plan Name is Not a String");
        } else if(strlen($shiftPlanName) > 20){
            throw new \OutOfRangeException("Shift Plan Name is Too Long");
        }
        $this->shiftPlanName = $shiftPlanName;
    }

    public function getShiftPlanName():string{
        return $this->shiftPlanName;
    }

}