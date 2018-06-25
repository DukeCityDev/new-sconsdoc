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

    public function __construct($podId, $podName)
    {
        try{
            $this->setPodId($podId);
            $this->setPodName($podName);
        }catch(\InvalidArgumentException $e){
            throw new \InvalidArgumentException($e->getMessage(), 0, $e);
        } catch(\OutOfRangeException $e){
            throw new \OutOfBoundsException($e->getMessage(),0,$e);
        } catch(\TypeError $e){
            throw new \TypeError($e->getMessage(),0,$e);
        } catch(\OutOfRangeException $e){
            throw new \OutOfRangeException($e->getMessage(),0,$e);
        } catch(\Exception $e){
            throw new \Exception($e->getMessage(),0,$e);
        }
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


    public function setPodName(string $podName):void
    {
        $podName = trim($podName);

        if(!is_string($podName)){
            throw new \TypeError("Expected Pod Name to Be a String");
        } else if(strlen($podName) > 45){
            throw new \OutOfRangeException("Pod Name is Too Lomg");
        } else if(strlen($podName) === 0 ){
            throw new \OutOfRangeException("Pod is Too Short");
        }
        $this->podName = $podName;
    }

    public function insert(\PDO $pdo):void{
        if($this->podId !== null){
            throw (new \PDOException("Not a new SCON"));
        }

        $query = "INSERT INTO pod (podId, podName) VALUES(:podId, :podName)";
        $statement = $pdo->prepare($query);
        $parameters = ["podId" => $this->getPodId(), "podName"=> $this->getPodName()];

        $statement->execute($parameters);

        $this->podId = intval($pdo->lastInsertId());
    }

    public function update(\PDO $pdo):void{

        if($this->podId == null){
            throw (new \PDOException("Cannot update a Pod that does not exist"));
        }

        $query = "UPDATE pod SET podId = :podId, podName = :podName WHERE podId = :podId";
        $statement = $pdo->prepare($query);
        $parameters = ["podId"=>$this->getPodId(), "podName"=> $this->getPodName()];
        $statement->execute($parameters);
    }

    public function delete(\PDO $pdo):void{
        if($this->podId == null){
            throw (new \PDOException("Cannot update a Pod that does not exist"));
        }

        $query = "DELETE FROM pod WHERE podId = :podId";
        $statement = $pdo->prepare($query);
        $parameters = ["podId"=>$this->podId];
        $statement->execute($parameters);
    }

    public static function getPodByPodName(\PDO $pdo, $podName): ?Pod{
        $podName =  trim($podName);
        $query = "SELECT podId, podName FROM pod WHERE podName=:podName";
        $statement = $pdo->prepare($query);
        $parameters = ["podName"=> $podName];
        $statement->execute($parameters);
        $pod = null;
        try{
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false){
                $pod = new Pod($row["podId"],$row["podName"]);
            }
        }catch(\Exception $e){
            throw(new \PDOException(new \PDOException($e->getMessage(),0,$e)));
        }

        return ($pod);
    }


}