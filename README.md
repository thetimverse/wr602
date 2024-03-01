Symfony PDF Generator App
========================

Requirements
------------

  * The [usual Symfony application requirements][1].

Installation
------------
[Download Composer][6] and use the `composer` binary installed
on your computer to run these commands:

```bash
# you can clone the code repository and install its dependencies
$ git clone https://github.com/thetimverse/wr602.git my_project
$ cd my_project/
$ composer install
# create the database
$ php bin/console doctrine:database:create
$ php bin/console make:migration
$ php bin/console doctrine:migrations:migrate
# and that's it, you're all set!
```
Usage
-----

There's no need to configure anything before running the application. There are
2 different ways of running this application depending on your needs:

**Option 1.** [Download Symfony CLI][4] and run this command:

```bash
$ cd my_project/
$ symfony server:start
```

Then access the application in your browser at the given URL (<http://127.0.0.1:8000/> by default).

**Option 2.** Use a web server like Nginx or Apache to run the application
(read the documentation about [configuring a web server for Symfony][3]).

On your local machine, you can run this command to use the built-in PHP web server:

```bash
$ cd my_project/
$ php -S localhost:8000 -t public/
```

[1]: https://symfony.com/doc/current/setup.html#technical-requirements
[3]: https://symfony.com/doc/current/setup/web_server_configuration.html
[4]: https://symfony.com/download
[6]: https://getcomposer.org/