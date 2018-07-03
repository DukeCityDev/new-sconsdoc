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
    private $sconId;
    private $podId;
    private $shiftPlanId;
    private $startDate;
    private $endDate;
    private $available;

    public function __construct(?int $shiftId, int $sconId, int $podId, int $shiftPlanId, \DateTime $startDate, \DateTime $endDate, boolean $available){

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

    public function setPodId( int $pod){

    }

}