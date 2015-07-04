# SimpleFM Exploration

This is a demo project I created to learn and explore the [SimpleFM](https://github.com/soliantconsulting/SimpleFM) package in preparation for an upcoming project as an alternative to the official FileMaker PHP API. 

The project brings the SimpleFM package into the [Laravel 5.1](http://laravel.com/) framework.

The project shows how to do basic CRUD interaction against a database of zip codes.


# Website Setup

With the Laravel framwork, the root web folder (i.e. where you should point your web server's document root to) is the `public` folder.

Before you move the files to your web server, pull the FileMaker database out (there's no reason to have the FileMaker file with your web files). The file is located at:

    FileMakerDatabase/ZipCodes.fmp12

## Updating the environment file

Laravel uses a `.env` file to hold credentials specific to your environment (e.g. database credentials, application key, etc). The `.env` file should **not** be committed to your version control as it is specific to a hosting environment. 

You'll need to create a `.env` file to use this project. To do so:

- Make a copy of the `.env.example` file found at the root of this project and name it `.env`
- In the terminal, cd to the root of the project and run the following command to generate the application key:

        php artisan key:generate

- Open the `.env` file. At the bottom you'll fine the `FM_...` configuration items.
    - Change the `FM_HOSTNAME` value to your FileMaker Server's IP or domain name
    - If you're changing the username and password for the demo account in the FileMaker file, change the `FM_USERNAME` AND `FM_PASSWORD` config items to match. 

## Installing the composer packages

Once your files are hosted on your web server you'll need to install the packages for the project. You can do this by:

- Opening the terminal
- Navigating to the root of the project
    - You should see the `composer.json` file
- Run the following command:

        sudo composer install

# The FileMaker Database Setup

This project uses a FileMaker database as the data source.

To setup the database you will need to be able to host the database on a FileMaker Server.

## Credentials

Since this is a demo it's ok to post the credentials online, however *if you plan on hosting this file on a public facing server of any kind (production or development) **it is strongly recommended that you change the passwords***. Hosting any FileMaker file (even a demo file) on a public facing server with a compromised Full Access password is a huge security risk.

### Full Access Account
- Admin
- zkE2WJJvzhsJQ3z

### Account used by the web server
- demo
- zipcodesdemo!

### Setup

- Confirm that the FileMaker Server you're going to host the database from has the Web Publishing Engine turned on and XML is enabled.
- Host ZipCodes.fmp12 on a FileMaker Server.
- Confirm that you can log in to each account via FileMaker Pro.
- Open a web browser and confirm you can access the database via the following url (replace the `127.0.0.1` with your FileMaker Server's IP or domain name):
    
        http://127.0.0.1/fmi/xml/fmresultset.xml?-db=ZipCodes&-lay=Zips&-findany
