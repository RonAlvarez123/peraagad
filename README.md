# Peraagad

Peraagad is a multi-level marketing platform/web application where customers can earn money in two ways. Either by referring another customer or by using micro-transactions that are available in the application.


Technologies that are used in the making of this project are:
1. PHP/Laravel - for all of the back end functionalities of the application.
2. CSS/SCSS - Specifically css grid and flexbox. Styles are written in SCSS format to utilize SASS selector nesting, variables, etc.
3. Bootstrap - Bootstrap classes are used in some dynamic rendering.
4. HTML - Structure of the page.
5. Blade - Templating engine of laravel that is used in dynamic rendering and page manipulation.



***

To have a demo of the application, follow these steps:

First, open a terminal and go to any directory that you want the app to be placed.


> cd {whatEverDirectory}


Now we need to clone the application.


> git clone https://github.com/RonAlvarez123/peraagad


After the application is cloned. Go inside the application's folder.


> cd peraagad


Now we need to install all the dependencies of the application.


> composer install


If the composer packages are finished installing, now we need the npm packages.


> npm install


We got the dependencies we need, now we need to create a .env file inside the folder of the application.

Go inside the application's folder and create a .env file.

And then, open the .env.example file and copy all of its contents and paste it inside the .env file that we have just created and then save it.

Now, go back into the terminal and type:


> mysql -u root


Now, we need to create a database that our application will use.


> CREATE DATABASE peraagad;


We created a database that is named peraagad because it is the value of our DB_DATABASE variable inside the .env file.
If you happened to change the value of DB_DATABASE in our .env file, then you should also create a database with the name that matches whatever value that you put in the DB_DATABASE variable.


After you created a database, press CTRL + C to exit the MariaDB monitor.


Now we need to generate our application key that our application will use.


> php artisan key:generate


Now we can visit our application by typing in the terminal:


> php artisan serve


You can now open a web browser, preferrably Chrome or Firefox, and go to localhost:8000 or copy the link of our Development Server that artisan logged.
