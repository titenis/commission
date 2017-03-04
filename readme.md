# Commissions calculation from file
## requirements
- php 7.0
- bcmath php extension

## commands to run
- `composer install`
- `php bin/console commissions:get-from-file tmp/data.csv`

## commands to test
- `php vendor/phpunit/phpunit/phpunit --coverage-text`

![alt text](https://travis-ci.org/titenis/commission.svg?branch=master)

```
Code Coverage Report:      
  2017-03-04 19:36:33      
                           
 Summary:                  
  Classes: 90.48% (19/21)  
  Methods: 95.52% (64/67)  
  Lines:   90.76% (226/249)
```
