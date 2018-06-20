<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 6/19/2018
 * Time: 2:43 PM
 */
namespace Unm\Scheduler;
use Unm\Scheduler\Tests\SchedulerTest;
use Unm\Scheduler\Scon;
require_once(dirname(__DIR__) . "/autoload.php");
require_once("SchedulerTest.php");
/**
 * UserTest Class
 *
 * This User Test will test the search for users by Id, Username,
 *
 *
 **/


class SconTest extends SchedulerTest{

    protected $VALID_NET_ID = "testperson";
    protected $VALID_FIRST_NAME = "Daniel";
    protected $VALID_LAST_NAME = "Eaton";
    protected $VALID_EMAIL = "deaton747@unm.edu";
    protected $VALID_MIDDLE_INITIAL = "G";
    protected $VALID_PHONE_NUMBER = "(505)-301-4619";
    protected $VALID_START_DATE;
    protected $VALID_ADMIN_STATUS = true;
    protected $VALID_HASH;
    protected $VALID_SALT;

    protected $user = null;
    public final function setUp() {
        $this->VALID_START_DATE = new \DateTime('now');
        $this->VALID_START_DATE = $this->VALID_START_DATE->format("Y-m-d");
    }
    /**
     * test inserting a valid Scon and verify that the actual mySQL data matches
     **/
    public function testInsertValid() {


        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("scon");
        // create a new User and insert to into mySQL
        $scon = new Scon(null,$this->VALID_FIRST_NAME, $this->VALID_LAST_NAME,$this->VALID_MIDDLE_INITIAL, $this->VALID_NET_ID, $this->VALID_EMAIL, $this->VALID_PHONE_NUMBER, $this->VALID_START_DATE, $this->VALID_ADMIN_STATUS);
        $scon->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoScon = Scon::getSconBySconId($this->getPDO(), $scon->getSconId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
        $this->assertEquals($pdoScon->getSconId(), $this->VALID_USERNAME);
        $this->assertEquals($pdoScon->getUserFirstName(), $this->VALID_FIRST_NAME);
        $this->assertEquals($pdoScon->getUserLastName(), $this->VALID_LAST_NAME);
        $this->assertEquals($pdoScon->getUserEmail(), $this->VALID_EMAIL);
        $this->assertEquals($pdoScon->getUserHash(), $this->VALID_HASH);
        $this->assertEquals($pdoScon->getUserSalt(), $this->VALID_SALT);
    }
    /**
     * test inserting a User that already exists
     * @expectedException \PDOException
     **/
    public function testInsertInvalidUser() {
        // create a User with a non null user id and watch it fail
        $user = new User(UNMTest::INVALID_KEY, $this->VALID_USERNAME, $this->VALID_FIRST_NAME, $this->VALID_LAST_NAME, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT);
        $user->insert($this->getPDO());
    }
    /**
     * test inserting a User, editing it, and then updating it
     **/
    public function testUpdateValidUser() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("user");
        // create a new User and insert to into mySQL
        $user = new User(null, $this->VALID_USERNAME, $this->VALID_FIRST_NAME, $this->VALID_LAST_NAME,$this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT);
        $user->insert($this->getPDO());
        // edit the User and update it in mySQL
        $user->setUserUserName($this->VALID_USERNAME);
        $user->update($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
        $this->assertEquals($pdoUser->getUserUserName(), $this->VALID_USERNAME);
        $this->assertEquals($pdoUser->getUserFirstName(),$this->VALID_FIRST_NAME);
        $this->assertEquals($pdoUser->getUserLastName(),$this->VALID_LAST_NAME);
        $this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
        $this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
        $this->assertEquals($pdoUser->getUserSalt(), $this->VALID_SALT);
    }
    /**
     * test updating a User that does not exist
     * @expectedException \PDOException
     **/
    public function testUpdateInvalidUser() {
        // create a User, try to update it without actually inserting it and watch it fail
        $user = new User(null, $this->VALID_USERNAME, $this->VALID_FIRST_NAME,$this->VALID_LAST_NAME,$this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT);
        $user->update($this->getPDO());
    }
    /**
     * test creating a User and then deleting it
     **/
    public function testDeleteValidUser() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("user");
        // create a new User and insert to into mySQL
        $user = new User(null, $this->VALID_USERNAME, $this->VALID_FIRST_NAME,$this->VALID_LAST_NAME,$this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT);
        $user->insert($this->getPDO());
        // delete the User from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
        $user->delete($this->getPDO());
        // grab the data from mySQL and enforce the User does not exist
        $pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
        $this->assertNull($pdoUser);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("user"));
    }
    /**
     * test deleting a User that does not exist
     * @expectedException \Exception
     **/
    public function testDeleteInvalidUser() {
        // create a User and try to delete it without actually inserting it
        $user = new User(null, $this->VALID_USERNAME, $this->VALID_FIRST_NAME,$this->VALID_LAST_NAME,$this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT);
        $user->delete($this->getPDO());
    }
    /**
     * test grabbing a User by user name
     **/
    public function testGetValidUserByUserUsername() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("user");
        // create a new User and insert to into mySQL
        $user = new User(null, $this->VALID_USERNAME, $this->VALID_FIRST_NAME,$this->VALID_LAST_NAME,$this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT);
        $user->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $results = User::getUserByUserUserName($this->getPDO(), $user->getUserUserName());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
        //$this->assertCount(1, $results);
        //$this->assertContainsOnlyInstancesOf("Unm\\Deaton\\User", $results);
        // grab the result from the array and validate it
        $pdoUser = $results;
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
        $this->assertEquals($pdoUser->getUserUserName(), $this->VALID_USERNAME);
        $this->assertEquals($pdoUser->getUserFirstName(),$this->VALID_FIRST_NAME);
        $this->assertEquals($pdoUser->getUserLastName(),$this->VALID_LAST_NAME);
        $this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
        $this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
        $this->assertEquals($pdoUser->getUserSalt(), $this->VALID_SALT);
    }
    /**
     * test grabbing all Users
     **/
    public function testGetAllValidUsers() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("user");
        // create a new User and insert to into mySQL
        $user = new User(null, $this->VALID_USERNAME,$this->VALID_FIRST_NAME,$this->VALID_LAST_NAME, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT);
        $user->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $results = User::getAllUsers($this->getPDO());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
        $this->assertCount(1, $results);
        $this->assertContainsOnlyInstancesOf("Unm\\Deaton\\User", $results);
        // grab the result from the array and validate it
        $pdoUser = $results[0];
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
        $this->assertEquals($pdoUser->getUserUserName(), $this->VALID_USERNAME);
        $this->assertEquals($pdoUser->getUserFirstName(),$this->VALID_FIRST_NAME);
        $this->assertEquals($pdoUser->getUserLastName(),$this->VALID_LAST_NAME);
        $this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
        $this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
        $this->assertEquals($pdoUser->getUserSalt(), $this->VALID_SALT);
    }
}
