<?php

namespace Sahal\Deputy\Test;

use PHPUnit\Framework\TestCase;

// Class to test the Hierarchy.
class HeirarchyTest extends TestCase {

    /**
     * Constructor to initialize the values
     *
     * 
     */
    public function __construct() {
        parent::__construct();

        // Example roles
        $this->roles = '[{"Id": 1,"Name": "System Administrator","Parent": 0},{"Id": 2,"Name": "Location Manager","Parent": 1},{"Id": 3,"Name": "Supervisor","Parent": 2},{"Id": 4,"Name": "Employee","Parent": 3},{"Id": 5,"Name": "Trainer","Parent": 3}]';        

        // Examples users
        $this->users = '[{"Id": 1,"Name": "Adam Admin","Role": 1},{"Id": 2,"Name": "Emily Employee","Role": 4},{"Id": 3,"Name": "Sam Supervisor","Role": 3},{"Id": 4,"Name": "Mary Manager","Role": 2},{"Id": 5,"Name": "Steve Trainer","Role": 5}]';

        // SubOrdinates of Role ID 3
        $this->role3 = '[{"Id": 2,"Name": "Emily Employee","Role": 4},{"Id": 5,"Name": "Steve Trainer","Role": 5}]';

        // SubOrdinates of Role ID 1
        $this->role1 = '[{"Id": 4,"Name": "Mary Manager","Role": 2},{"Id": 3,"Name": "Sam Supervisor","Role": 3},{"Id": 2,"Name": "Emily Employee","Role": 4},{"Id": 5,"Name": "Steve Trainer","Role": 5}]';
    }

    /**
     * Testing an empty Hierarchy Tree
     *
     * @return status;
     */
    public function testCreateEmptyHierarchy() {
        $agent = $this->createObject();
        $this->assertSame([], $agent->data);
    }

    /**
     * Testing the Hierarchy with the roles initialized in constructor
     *
     * @return status;
     */
    public function testHierarchyWithRoles() {
        $agent = $this->createObject($this->roles);
        $this->assertSame(5, $agent->totalRoles());
    }

    /**
     * Testing the Hierarchy with the roles and users initialized in constructor
     *
     * @return status;
     */
    public function testHierarchyWithRolesAndUsers() {
        $agent = $this->createObject($this->roles);
        $this->assertTrue($agent->setUsers($this->users));
    }

    /**
     * Testing if all the roles and users are printed successfully (should return true)
     *
     * @return status;
     */
    public function testPrintingAllValues() {
        $agent = $this->createObject($this->roles);
        $this->assertTrue($agent->printValues());
    }

    /**
     * Testing is the setUsers functionality returns all the employee objects correctly for Role ID 3
     *
     * @return status;
     */
    public function testGetSubOrdinatesRole3() {
        $agent = $this->createObject($this->roles);
        $agent->setUsers($this->users);
        $answer = json_decode($this->role3);

        $this->assertEqualsCanonicalizing($answer, $agent->getSubOrdinates(3));
    }

    /**
     * Testing is the setUsers functionality returns all the employee objects correctly for Role ID 1
     *
     * @return status;
     */
    public function testGetSubOrdinatesRole1() {
        $agent = $this->createObject($this->roles);
        $agent->setUsers($this->users);
        $answer = json_decode($this->role1);

        $this->assertEqualsCanonicalizing($answer, $agent->getSubOrdinates(1));
    }

    /**
     * Function to create Hierarchy object
     *
     * @return object;
     */
    private function createObject($data = NULL) {
        $agent = new \Sahal\Deputy\Hierarchy($data);
        return $agent;
    }
}