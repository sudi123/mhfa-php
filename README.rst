Login/Registration functionality

index.php - single home page which contains seperate html forms for login and registration
register.php - php page that performs user registration to the database.
                All the fields should be filled in order to complete registration.
login.php - php page that checks for the credentials entered in the login form and matches it agains the
            credentials stored in database. If the credentials match, it displays the value of row2 from
            'contents' table. Else it displays "invalid username/password"
checkusername.php - php page to check if the username already exists in the database. Jquery calls this page for username validation

JQuery files are maintained in
/js/script.js
scripts.js - JQuery client side validation and ajax calls to PHP pages during login and registration

Stylesheets are maintained in
/css/styles.css

Two class files
/entities/Response.php -    Response class that returns Response Message and Response Flag. The response
                            object is returned from login.php to AJAX call and the result is displayed based on the response message
/constants/Constants.php -  Class that store constants.

Test case:
The database has two tables 'users' and 'contents'.
A test user has been created in the database for testing.
username: testuser
password: Password1

