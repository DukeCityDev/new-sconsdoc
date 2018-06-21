<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 6/21/2018
 * Time: 12:16 PM
 */

namespace Unm\Scheduler;
require_once(dirname(__DIR__) . "/autoload.php");
//  podId INT UNSIGNED AUTO_INCREMENT,
//podName VARCHAR(20) UNIQUE

class Pod
{
    private $podId;
    private $podName;

    public function __construct()
    {

    }

    /**
     * @return int
     */
    public function getPodId(): int
    {
        return $this->podId;
    }

    /**
     * @param mixed $podId
     */
    public function setPodId(?int $podId)
    {
        if(!is_null($podId)){
            if(!is_int($podId)){
                throw new \InvalidArgumentException("Pod Id is Invalid: Not An Integer");
            } else if($podId < 0){
                throw new \InvalidArgumentException("Pod ID is Invalid: Negative Integer");
            } else if($podId >= 4294967296){
                throw new \OutOfBoundsException("Pod ID is Invalid: Maximum INT(10) Size, assign more bytes to Pod Id");
            }
        }
        $this->podId = $podId;
    }

    /**
     * @return string
     */
    public function getPodName() :string
    {
        return $this->podName;
    }


    public function setPodName(string $podName)
    {
        $podName = trim($podName);

        if(!is_string($podName)){
            throw new \TypeError("First Name is Not a String");
        } else if(strlen($podName) > 45){
            throw new \OutOfRangeException("First Name is Too Lomg");
        } else if(strlen($podName) === 0 ){
            throw new \OutOfRangeException("First Name is Too Short");
        }
        $this->podName = $podName;
    }

}