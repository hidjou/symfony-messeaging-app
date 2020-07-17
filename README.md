# Symfony Messaging App

## How to run

-   run `composer install` to install all the dependencies needed
-   Add TwilioAPI entries for `TWILIO_SID` and `TWILIO_AUTH_TOKEN` in the `.env` file
-   Add a username, password, host and database name in a DB connection string in the `.env` file
-   Either create the DB manually or run `php bin/console doctrine:database:create`
-   Run `doctrine:migrations:migrate` to create the tables and db schema
-   Either set up a virual host pointing to the public folder or use the symfony CLI and run `symfony server:start`

And start texting away :)
