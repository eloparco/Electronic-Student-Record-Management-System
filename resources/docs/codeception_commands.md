# Useful codeception commands
## run all tests
php vendor/bin/codecept run

## run only unit tests
php vendor/bin/codecept run unit
## run only acceptance tests
php vendor/bin/codecept run acceptance

## run specific test class
php vendor/bin/codecept run unit UtilityTest  
php vendor/bin/codecept run acceptance Story8Cest

## run specific function
php vendor/bin/codecept run unit UtilityTest:functionName  
php vendor/bin/codecept run acceptance Story8Cest Story8Cest:functionName  

## generate unit test class
php vendor/bin/codecept generate:test unit Example  
-> *generate file ExampleTest.php*
## generate acceptance test class
php vendor/bin/codecept g:cest acceptance Story3  
-> *generate file Story3Cest.php*

## use debugger
```
codecept_debug($variable); // add this line in the code
```
php vendor/bin/codecept unit UtilityTest **--debug**

