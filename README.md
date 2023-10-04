
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


### ROLE AND PERMISSION

The concept behind the role and permissoin is like below

* First we create role for an organization or ministry
* Second we seed all permission from database seeder (permissionSeeder)
* Third we create role and give required permission to role
* role have many permisison and permisison has is related to an gurad
* Every user has role and base on role we check the user permission in ability middleware
* Implementation of ever permission is written in sperate policy bcz of easy management
* User can have permission directly or via a role
* By defualt super_admin user have all permissions
* Permission are checking in every API request, if user has not permisison then the called api shows that you don't have sufficient permission
* there are some public route that user can access them without any permission
* Permissions are managent based on JWT


### WORKFLOW AND REQUEST PROCESS

The concept behind it, is like below

we have 3 important component in request process using workflow

# Letter
A letter is an applicaion where it comes form out side either inside to out ministry

* it has a uniqur ref number, type, and from organization

# Letter Request 
A letter Request is the workflow step tracer which we can tracke the income/outgoing request workflow step.

* it define the applicaiont/letter current step in a workflow
* Manage the request workflow next action 
* we can check the process status

# Work Flow Step 
A Work flow step define all steps that a request must go on that and which action should be done in this step.

# Request Activity Log
Used to manage all activities that are done on a request

# How workflow work

once the request comes and registered, a new record on letter request will be created that define the current step of the applicaion/letter, then workflow will be start, in each work flow step we have actions field that define which Action should be done in this step, once the process of action completed, the current step will be udpated, and log will be generate on request.






