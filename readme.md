## Technologies

Laravel 5.6 (php 7.2) was used as the backend language for this project due to the built-in tools available. It was also a chance to catch up on Laravel since I last used it, this is why I have used version 5.6 so I could learn some of the newest features that it has to offer.

ReactJS was used as the client side framework. React is a very powerful and easy to use front-end framework. It was chosen because it can be linked easily with Laravel using webpack and mixin. It is also a framework I have been looking to use more and more in the future because of the use of states and components allowing for more maintainable and resuable code.

MySQL was used as the database. This was used so I could take advantage of the simplicity and security of Laravel's Eloquent ORM. Using a relational database also allows for restriction using foreign keys, which important with thetable structure I have chosen and prevents against the accumulation of bad data.

## Installation

1.  Use git clone to download the project into your directory.
Use the command line in the new directory and run the following

    `` composer install `` 

    to install the dependencies required by Laravel

    `` npm install ``

    to install the dependencies required by the React Client, optional for just testing as the javascript file for the application is already compiled

2.  Setup a local database and create a new schema for this project 

3.  Copy the ``.env.example`` file in the application root and name it ``.env``

4.  Change the ```.env``` file in the applications root folder so it uses your local database and the new schema

5.  Run ``php artisan migrate`` to populate the database schema with the correct tables for the project

6.  Run ``php artisan key:generate`` to generate an encryption key in the ``.env`` file

7.  Run ``php artisan serve`` to fire up the server

8.  Test at `http://localhost:8000/references` 

9.  To run the feature and unit tests go to the root directory and use the following commands

    ``cd vendor/bin``
    
    ``phpunit --configuration ../../phpunit.xml``
    
10.  Download Postman / Fiddler 4 / any other API development environment. Use this to replicate the API POST to the ``/api/references`` route using a json structure below (this particular json will populate the record for the tests) the following


    {
        "reference": 10,
        "email": "test@test.com",
        "providers": {
            "mind-x": {
                "status": "passed",
                "score": 13,
                "failed": 2
        },
        "shl": {
                "status": "passed",
                "score": 29,
                "failed": 1
        },
        "talentq": {
                "status": "failed",
                "score": 2,
                 "failed": 25
        }
    }
    
    
_Note: POST request must be sent with the content type of ``application/json`` and follow the rules set out in the pdf. This API also a maximum length of JSON of a 1000 and uses IP whitelisting for added security. However, for testing purposes this can be commented out in ``App/Http/Requests/ReferencesAPIRequest.php``_    
   
## API Routes

Get a singular reference

``GET   /api/reference/{reference}``

Get all references

``GET   /api/references`` 

Get all references by email

``GET   /api/references/{email}``

Create or update a reference

``POST  /api/reference``

``PUT   /api/reference``

Delete a reference

``DELETE    /api/reference/{reference}``

Get reference providers

``GET   /api/reference/providers/{id}``



