# Map Places

Place markers on the map using google maps API and your API key. Made with PHP, MySQL, JS, SASS (SCSS).

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

```
NetBeans IDE 8.2 with PHP
XAMPP for MySQL and PhPMyAdmin
```

### Installing

A step by step series of examples that tell you how to get a development env running

Step 1

```
Clone the repository to your local machine and open in NetBeans.
```

Step 2

```
Download Xampp, run Apache and MySQL in Xampp. open PhPMyAdmin in localhost and create a database "map_places" with a table "markers" in it.
Create necessary fields (ID, Name, Address, latitude, longitude, type and hours)
```

Step 3

```
Create a file called phpsqlajax_dbinfo.php in source files and add $username, $password and $database variables.
Get your api key from google and add it to map.php file.
```
Step 4

```
Change center property in script.js row 24 to center where ever you want.
Run the program on browser and add markers to your project to see them on map.
```

## Built With

PHP

MySQL

JavaScript

SASS


## Author

Olli L.
