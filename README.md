### Project information
Project made with Laravel 9.

The purpose of this code is that by executing a command, it can parse csv and xml files to extract information and return a table showing the most suspicious electricity readings from customers.

## User's manual
Once the project is cloned, we must follow these steps:
- Copy the .env.example with the name .env
- Run composer install
- Run php artisan migrate


When all this is done, we simply have to launch the command that analyzes the files.

Currently we have two files:
- 2016-readings.csv
- 2016-readings.xml

The command to analyze each of them is the same, varying the last part where the name is indicated.

Examples:
- php artisan readings:import-analyze 2016-readings.csv
- php artisan readings:import-analyze 2016-readings.xml


## How does it work?
We have two files stored in the project, which will be imported and analyzed by the same command.

The process will make sure that the file exists, that it is no larger than 2MB and that it has the correct extension.

Once these possible exceptions have been validated, first all the information will be imported to the database we have configured, in this case SQLite.

Once the import process has finished, the analysis process will start, resulting in a table in the console that will show the suspicious results based on the average annual consumption + 50% of each customer.

## Code details
In the implementation of this code, the intention has been to apply hexagonal architecture, DDD pattern and the implementation of basic unit tests to check a couple of functions.
