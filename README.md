# Four in line - AAT

The game for in line, made in PHP using the framework **Laravel**. In this game there are two players, one red and one blue, they alternate placing pieces on the board. The winner is the first to make a line of four pieces of their colour.

<br/>

## Requirements
To run this proyect three different aplications are needed:
- Docker (https://docs.docker.com/desktop/)
- DDEV (https://ddev.readthedocs.io/en/stable/)
- Composer (https://getcomposer.org/download/)

<br/>

# Running the project
Actually running this proyect requires a number of steps, all these asume that the software in the requirements is installed and working.

## Getting the proyect
To get the proyect run ``git clone https://github.com/Tinch334/cuatroenlinea``.

<br/>

## Creating an environment(Conteiner creation)
To configure the project we run:
>``ddev config``

When we do this a series of prompts will appear. First ``proyect name``, leave this field empty and simply press enter, this will use the name of the folder.  Next ``docroot location ``, again don't enter anything and press enter. Finally when asked the type of project enter ``laravel``.

When the configuation is done it should give you a url that looks something like ``https://cuatroenlinea-master.ddev.site``. Try going to it and check if it works, if so great! Otherwise continue reading.

<br/>

## Configuration problems
If the above page didn't work you probably got a message similar to:

![Page not working example](https://cdn.discordapp.com/attachments/982774069663531021/982774389940564049/Screenshot_page_not_working.png)

Keep in mind that not all error messages will look the same, this is just an example. If you got an error message of any kind you will have to perform a few more steps to get the proyect to work.

### Composer
The first thing to do if you are having trouble is update your dependencies. In the case of PHP we are using ``Composer``.  To update all packages run:
> ``composer update``

When you run this is very likely you'll have some erros, they can take many forms, but most commonly they look something like this:
> ``Your requirements could not be resolved to an installable set of packages.``

> ``The requested PHP extension dom is missing from your system.``

In this case the error can most often be solved by running:
> ``sudo apt-get install php-xml``

This should install al missing packages and allow composer to work poperly. If you still encounter an error however, particullarly one that says:
> ``The requested PHP extension curl is missing from your system``

Then you will have to also update ``php-curl``, to do this you first need your version of PHP, to get it run:
> ``php -v``

The first line should look somehing like this ``PHP 7.4.3 (cli) (built: Mar  2 2022 15:36:52) ( NTS )`` The numbers you see after PHP are your version. Once you have it run:
``sudo apt-get install <php-version>-curl``

This will install the appropiate curl version needed for your version, it's very important that you do not install the wrong one as it can cause conflicts.

###  Checking composer
After doing all this composer should now work, to check we again run:
> ``composer update``

If everything is working correctly then you sould see no errors and get a message that looks something like this: ``Package manifest generated successfully. 77 packages you are using are looking for funding.``

This means that all dependencies were succesfully updated and we are ready to start our page.

<br/>

## Running the project
Now that everything is ready we can run the project to do this we execute:
> ``ddev start``

Doing so will give you a URL, if you followed all the steps it should be: ``https://cuatroenlinea-master.ddev.site``

### Encryption key
When you go to that link you will se a message like this:
![Encryption key problem](https://cdn.discordapp.com/attachments/982774069663531021/982774389672124477/Screenshot_key_missing.png)

 On the page below that message you will see a button to generate the necessary encryption key, press it.

### Page works
After doing that you can refresh the page and it should work, showing you the following.
![Working page](https://cdn.discordapp.com/attachments/982774069663531021/982774389319827536/Screenshot_works.png)

If you see this page it means that everything works properly.

### Checking the game
To make shure the game works go to the URL ``https://cuatroenlinea-master.ddev.site/jugar/1``, beware it can take some time to load.

If the game is working as intended then you should see the board with a single red piece at the bottom left. If you see that, ot means that the game works correctly and you can be happy.
![Working game](https://cdn.discordapp.com/attachments/982774069663531021/982779372488523786/Screenshot_game.png)

<br/>

## Shutting down the project
It's a bad idea to shut down the project by simply terminating the process or closing the console in which it's running. This is beacuse killing the process doesn't terminate all the things created by ddev to run the page (containers, virtual networks, etc).
To properly shut down the project run:
> ``ddev stop``

After stopping the process you should see the line ``Project cuatroenlinea-master has been stopped.``. This means everything was shut down properly.
