# Deputy Coding Challenge

## Objective 

Develop a function, for an arbitrary collection of roles and users, given a user Id returns a list of ALL their subordinates (i.e: including their
subordinate's subordinates).

Examples have been provided in the PDF. 

## Getting Started

### Dependency Management

Install composer in your machine. 
Please visit https://getcomposer.org/download/ to download and install composer.


### Extract Code

You may extract the code from the ZIP file provided or pull the latest code from the git repository.
The following commands can be used to extract the code from git.

1. Create a directory of your choice in your local machine.
2. Open Terminal and navigate to the directory you just created.
2. Enter the following command: "git clone https://github.com/sahalk/users-hierarchy.git".

The code will now be present in this directory.


### Installing Dependencies 

Open the directory from your terminal and enter the following code: "composer install". This command will install all the required packages in this directory. 

### Execute! 

Once the packages have been installed, you will be able to run "PHPUnit" to run all the testcases. This project has been developed using TDD approach. You may use the following command to execute all the test cases: "./vendor/bin/phpunit -c phpunit.xml". Please note that the terminal prints additional values, these values are echo-ed onto the terminal to ensure that the create hierarchy is as expected. 

Additionally, if the local machine has "XDebug" (VS Code Plugin) installed. The file "HeirarchyTest.php" can be opened using VS Code and then from the debug options, the code can be executed using the option "Lauch currently open script".

XDebug is a tool that is used to debug PHP code and can be used to develop and debug your code. The can be extremely useful for developers writing code in PHP and would like to debug the code during the development process.

For more info, please visit: https://www.cloudways.com/blog/php-debug/

## Have fun! :)