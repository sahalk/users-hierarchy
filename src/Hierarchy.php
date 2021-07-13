<?php

namespace Sahal\Deputy;

// Class to create a Node for each Role and the users present in them. 
class Node {
    // All the properties for the Node.
    public $id;
    public $role;
    public $children;
    public $users;

    /**
     * Constructor to initialize the values
     *
     * 
     */
    public function __construct($roleObj) {
        $this->id = $roleObj->Id;
        $this->role = $roleObj->Name;
        $this->children = [];
        $this->users = [];
    }

    /**
     * Add a child to the Node. (Child Roles)
     *
     * @return true;
     */
    public function addChildren(Node $node) {
        // Check if node has a valid ID.
        if(isset($node->id)) {
            $this->children[] = $node;
            return true;
        }
        return false;
    }

    /**
     * Add users to the Node.
     *
     * @return true;
     */
    public function addUser(User $user) {
        // Check if user has a valid ID.
        if(isset($user->id)) {
            $this->users[] = $user;
            return true;
        }
        return false;
    }
}

// Class to create a User. 
class User {
    // All the properties for the User.
    public $id;
    public $name;
    public $role;
    public $userObj;

    /**
     * Constructor to initialize the user values.
     *
     * 
     */
    public function __construct($userObj) {
        $this->id = $userObj->Id;
        $this->name = $userObj->Name;
        $this->role = $userObj->Role;
        $this->userObj = $userObj;
    }

}

// Class to create the Hierarchy. 
class Hierarchy {
    // All the properties required for the Hierarchy.
    public $data;
    public $nodesArr;
    public $root = null;

    /**
     * Constructor to initialize the Roles and create a basic Tree.
     *
     * 
     */
    public function __construct($data = NULL) {
        // An array of all the roles present with key as Role ID.
        $this->nodesArr = [];

        // Decoding the JSON object.
        if(isset($data)) {
            $this->data = json_decode($data);
        } else {
            $this->data = [];
        }

        // Creating the tree.
        if($this->totalRoles() > 0) {
            foreach($this->data as $role) {
                $node = new Node($role);
                $this->nodesArr[$role->Id] = $node;
                if($role->Parent == "0") {
                    $this->root = $node;
                } else {
                    $parent = $this->nodesArr[$role->Parent];
                    $parent->addChildren($node);
                }
            }
        }
    }

    /**
     * Count the total number of nodes to be data.
     *
     * @return count;
     */
    public function totalRoles() {
        return count($this->data);
    }

    /**
     * Assign roles for each user.
     *
     * @return true;
     */
    public function setUsers($usersData) {
        // Decode the object.
        $users = json_decode($usersData);

        // Assigning all the roles.
        if($users) {
            foreach($users as $userObj) {
                $user = new User($userObj);
                if(isset($userObj->Role)) {
                    $roleNode = $this->nodesArr[$userObj->Role];
                    $roleNode->addUser($user);
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Return all the subordinates for a specific role ID.
     *
     * @return Object;
     */
    public function getSubOrdinates($roleID, $level = 0, $subObj = []) {
        // Getting the specific role.
        $role = $this->nodesArr[$roleID];

        // Printing all the values.
        if($level > 0) {
            foreach($role->users as $user) {
                echo $user->name . "\n";
                $subObj[] = $user->userObj;
            }
        } else {
            echo "\n\nAll Subordinates \n\n";
        }

        // Recursive function to extract and print all the children.
        foreach($role->children as $child) {
            $subObj = $this->getSubOrdinates($child->id, $level + 1, $subObj);
        }
        return $subObj;
    }

    /**
     * Print all values present in the tree.
     *
     * @return Object;
     */
    public function printValues() {
        // Print all the roles based on Heirarchy.
        foreach($this->nodesArr as $node) {
            echo $node->id . ". " . $node->role . "\n";
            echo "Children: ";
            if(count($node->children) < 1) {
                echo "None"; 
            } else {
                foreach($node->children as $child) {
                    echo $child->role; 
                    echo ", ";
                }
            }
            echo "\n";
            echo "Users: ";
            if(count($node->users) < 1) {
                echo "None"; 
            } else {
                foreach($node->users as $user) {
                    echo $user->name; 
                    echo ", ";
                }
            }
            echo "\n\n";
        }
        return true;
    }
}

$roles = '[{
    "Id": 1,
    "Name": "System Administrator",
    "Parent": 0
    },
    {
    "Id": 2,
    "Name": "Location Manager",
    "Parent": 1
    },
    {
    "Id": 3,
    "Name": "Supervisor",
    "Parent": 2
    },
    {
    "Id": 4,
    "Name": "Employee",
    "Parent": 3
    },
    {
    "Id": 5,
    "Name": "Trainer",
    "Parent": 3
    }]';

$users = '[
    {
    "Id": 1,
    "Name": "Adam Admin",
    "Role": 1
    },
    {
    "Id": 2,
    "Name": "Emily Employee",
    "Role": 4
    },
    {
    "Id": 3,
    "Name": "Sam Supervisor",
    "Role": 3
    },
    {
    "Id": 4,
    "Name": "Mary Manager",
    "Role": 2
    },
    {
    "Id": 5,
    "Name": "Steve Trainer",
    "Role": 5
    }
]';

$agent = new Hierarchy($roles);
$agent->setUsers($users);
$agent->printValues();
$agent->getSubOrdinates(3);
$agent->getSubOrdinates(1);