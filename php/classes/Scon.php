<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 6/14/2018
 * Time: 3:45 PM
 */


// NOTE: NETID CAN ONLY BE FROM 3-20 CHARACTERS


namespace classes;


class Scon
{
    private $sconId;
    private $firstName;
    private $lastName;
    private $middleInitial;
    private $netId;
    private $email;
    private $phoneNumber;
    private $startDate;
    private $adminStatus;


 public function __construct($sconId, $firstName, $lastName, $middleInitial,$netId, $email,$phoneNumber, $startDate, $adminStatus)
 {

 }

 public function setSconId(?int $sconId):void{
     if(!is_null($sconId)){

         if(!is_int($sconId)){
             throw new \InvalidArgumentException("Scon Id is Invalid: Not An Integer");
         } else if($sconId < 0){
             throw new \InvalidArgumentException("Scon ID is Invalid: Negative Integer");
         } else if($sconId > 4294967294){
             throw new \OutOfBoundsException("Scon ID is Invalid: Maximum INT(10) Size, asign more bytes to Scon Id");
         }
     }

     $this->sconId = $sconId;
 }

    /**
     * @return mixed
     */
    public function getSconId(): ?int
    {
        return $this->sconId;
    }


    public function setFirstName(string $firstName) : void
    {
        if(!is_string($firstName)){
            throw new \TypeError("First Name is Not a String");
        } else if(strlen($firstName) > 45){
            throw new \OutOfRangeException("First Name is Too Lomg");
        } else if(strlen($firstName) === 0 ){
            throw new \OutOfRangeException("First Name is Too Short");
        }

        $this->firstName = $firstName;
    }

    public function getFirstName() : string
    {
        return $this->firstName;
    }

    public function setLastName(string $lastName) : void
    {
        if(!is_string($lastName)){
            throw new \TypeError("Last Name is Not a String");
        } else if(strlen($lastName) > 45){
            throw new \OutOfRangeException("Last Name is Too Lomg");
        } else if(strlen($lastName) === 0 ){
            throw new \OutOfRangeException("Last Name is Too Short");
        }

        $this->lastName = $lastName;
    }

    public function getLastName():string{
        return $this->lastName;
    }

    public function setMiddleInitial(?string $middleInitial) : void
    {
        if(!is_null($middleInitial)){
            if(strlen($middleInitial) !== 1){
                throw new \OutOfRangeException("Middle Initial must only be one character.");
            }
        } else{
            $middleInitial =" ";
        }
        $this->middleInitial = $middleInitial;
    }

    public function getMiddleInitial():string
    {
        return $this->middleInitial;
    }

    public function setNetId(string $netId): void
    {
        if(!is_string($netId)){
            throw new \TypeError("NetId is Not a String");
        } else if(strlen($netId) > 20){
            throw new \OutOfRangeException("NetId is Too Long");
        } else if(strlen($netId) < 3 ){
            throw new \OutOfRangeException("NetId is Too Short");
        }
        $this->netId = $netId;
    }

    public function getNetId() : string
    {
        return $this->netId;
    }

    public function setEmail(string $email): void
    {
        if(!is_string($email)){
            throw new \TypeError("Email is Not a String");
        } else if(strlen($email) > 75){
            throw new \OutOfRangeException("Email is Too Long");
        } else if(strlen($email) < 5 ){
            throw new \OutOfRangeException("Email is Too Short");
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new \InvalidArgumentException("Email is not a valid email address.");
        }
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        if(!is_null($phoneNumber)){
            $phoneNumber = "";
        }
        if(!is_string($phoneNumber)){
            throw new \TypeError("Phone Number is Not a String");
        } else if(strlen($phoneNumber) > 17){
            throw new \OutOfRangeException("Phone Number is Too Long");
        }
        $this->phoneNumber = $phoneNumber;
    }

    public function getPhoneNumber() : \string
    {
        return $this->phoneNumber;
    }
}