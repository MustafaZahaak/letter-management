
## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## About project 

This project is designe for MCIT to manage the incomming and out going letter requests


## Modules

The project has below nodes/main components

1- Users 
2- User Management
3- Letters
4- Reuquests 
5- Approvals and workflows
6- Organizations
7- Permissions
8- Roles
9- Management
    9.1- Manage the historical data and request
    9.2- Optimizing the query of historical data
    9.3- Reporting


## Main Poinsts considered in this project

 * User ACL
 * Permisson managent for each request using middlewares
 * Workflow automation
 * Process the Request using the queuable interface to avoid missing the request
 * Load balancing
 * Using the process queue to manage the urgentnesss of request
 * Considering the security risk and attacks by resolving the vulnebrities
 * Manager Request troputs 
 * Implementing JWT for Permissions
 * Wrote the migration scripts to easy managing the databse tables
 * Implement The Rest API architecture
 * 


 ## This version Implementation notes

 * Used Passport for JWT managemnt
 * Used role and modle base structure for permisions
 * In Some case will use the events and to facilitate the proccess




### A deeper look on each module

* USER

in user have consider all CRUD APIs, Search Based on q  uery, Scope, Route Authorization, Checking permission, checking organizational level data.


### LETTERS/ Applications

* Checking permission in every API request 
* assigning a unique referene number
* Search Based on query parameter, Route Authorization
* Scoping the data to manage the amount of data to be retreived based on user type
* List based on key word 
* Validating the required payload
* All CRUD operation
* manage the applicaion/letter type











