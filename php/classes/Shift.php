<?php
/**
 * Created by PhpStorm.
 * User: deaton
 * Date: 7/2/18
 * Time: 6:30 PM
 */

namespace Unm\Scheduler;
require_once(dirname(__DIR__) . "/autoload.php");
require_once(dirname(__DIR__) . "/util/Util.php");

//CREATE TABLE shift(
//    shiftId INT UNSIGNED AUTO_INCREMENT,
//  sconNetId VARCHAR UNSIGNED,
//  podId INT UNSIGNED NOT NULL,
//  shiftPlanId INT UNSIGNED,
//  startDate DATETIME NOT NULL,
//  endDate DATETIME NOT NULL,
//  available BOOLEAN,
//
//  INDEX(sconId),
//  INDEX(podId),
//  INDEX(shiftPlanId),
//
//  PRIMARY KEY(shiftId),
//  FOREIGN KEY (sconId) REFERENCES scon(sconId),
//  FOREIGN KEY (podId) REFERENCES pod(podId),
//  FOREIGN KEY (shiftPlanId) REFERENCES shiftPlan(shiftPlanId)
//
//)CHARACTER SET utf8 COLLATE utf8_unicode_ci;



/**
 * Class Shift
 * @package Unm\Scheduler
 */
class Shift
{
    private $shiftId;
    private $sconNetId;
    private $podId;
    private $shiftPlanId;
    private $startDate;
    private $endDate;
    private $available;

    public function __construct(?int $shiftId, ?string $sconNetId, int $podId, int $shiftPlanId, \DateTime $startDate, \DateTime $endDate, boolean $available){

    }

    public function setShiftId(?int $shiftId):void{

        if(!is_null($shiftId)){

            if(!is_int($shiftId)){
                throw new \InvalidArgumentException("Shift Id is Invalid: Not An Integer");
            } else if($shiftId < 0){
                throw new \InvalidArgumentException("Shift ID is Invalid: Negative Integer");
            } else if($shiftId >= 4294967296){
                throw new \OutOfBoundsException("Shift ID is Invalid: Maximum INT(10) Size, assign more bytes to Shift Id");
            }
        }

        $this->shiftId = $shiftId;
    }

    public function getShiftId():?int{
        return $this->shiftId;
    }

    public function setSconNetId( ?string $sconNetId):void{
        if(!is_null($sconNetId)){
            if(!is_string($sconNetId)){
                throw new \TypeError("Scon Net Id is Not a String");
            } else if(strlen($sconNetId) > 20){
                throw new \OutOfRangeException("Scon Net Id is Too Long (More than 20 characters)");
            } else if(strlen($sconNetId) < 3 ){
                throw new \OutOfRangeException("Scon Net Id is Too Short (Less than 3 characters");
            }
        }

        $this->sconNetId = $sconNetId;
    }

    public function getSconNetId():?string{
        return $this->sconNetId;
    }

    public function setPodId(int $podId){
        if(!is_int($podId)){
            throw new \InvalidArgumentException("Pod Id is Invalid: Not An Integer");
        } else if($podId < 0){
            throw new \InvalidArgumentException("Pod ID is Invalid: Negative Integer");
        } else if($podId >= 4294967296){
            throw new \OutOfBoundsException("Pod ID is Invalid: Maximum INT(10) Size, assign more bytes to Pod Id");
        }

        $this->podId = $podId;
    }

    public function getPodId():int{
        return $this->getPodId();
    }

    public function setShiftPlanId(int $shiftPlanId):void{
        if(!is_int($shiftPlanId)){
            throw new \InvalidArgumentException("ShiftPlanId is Invalid: Not An Integer");
        } else if($shiftPlanId < 0){
            throw new \InvalidArgumentException("ShiftPlanId is Invalid: Negative Integer");
        } else if($shiftPlanId >= 4294967296){
            throw new \OutOfBoundsException("ShiftPlanId is Invalid: Maximum INT(10) Size, assign more bytes to Pod Id");
        }

        $this->shiftPlanId = $shiftPlanId;
    }

    public function getShiftPlanId():int{
        return $this->shiftPlanId;
    }

    public function setStartDate( ?\DateTime $date): void
    {
        if(is_null($date)){
            $date = new \DateTime("now");
        }
        if(!Util::verifyDate($date)){
            throw new \InvalidArgumentException("Date Time is not Valid");
        }
        $this->startDate = $date;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    public function setEndDate( ?\DateTime $date): void
    {
        if(is_null($date)){
            $date = new \DateTime("now");
        }
        if(!Util::verifyDate($date)){
            throw new \InvalidArgumentException("Date Time is not Valid");
        }
        $this->endDate = $date;
    }

    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @param mixed $available
     */
    public function setAvailable(boolean $available)
    {
        if(is_null($this->sconNetId && !$available)){
            throw new \InvalidArgumentException("Shift cannot be unavailable if it has no assigned Scon");
        }
        $this->available = $available;
    }

    /**
     * @return mixed
     */
    public function getAvailable():boolean
    {
        return $this->available;
    }


}