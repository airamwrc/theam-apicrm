# theam-apicrm  
Theam API CRM is a REST API developed in Symfony 4 to manage customer data.  
  
## Installation  
### Vagrant  
Once the project is downloaded, run:

    vagrant up

  > **Note:** When the virtual machine installation have finished, you could see some warnings like this which you can ignore:
default: mysql: [Warning] Using a password on the command line interface can be insecure..

After the installation, a database is created and a user with permissions to this one.  The created data are the next:
  
    - database: apicrm  
    - user: apicrmuser  
    - pass: acu678

A virtual host is also configured inside the virtual machine. Add a new line in the <i>hosts</i> file (<i>/etc/hosts</i> in Linux based systems) in your host machine to use it:  

    192.168.11.11 apicrm.theam

Access your virtual machine

    vagrant ssh
  
Locate at the root project directory

    cd /var/www/apicrm

Install dependencies

    composer install

Run the database migrations

    bin/console doctrine:migrations:migrate

In order to use the API you need to create an user

    bin/console fos:user:create test_user test@example.com 123456

Now, you are ready to use the API. You can checkout the API documentation in [here](doc/api-documentation.md)

### Installation without Vagrant
If you choose this option, you  need to create a database and an user with permission for this one.
In the root directory of the project, you need to create a .env file. You can use the .env.dist file in the project in order to this

    cp .env.dist .env

You need to configure the database configuration with your own data in the .env file

    DATABASE_URL=mysql://apicrmuser:acu678@127.0.0.1:3306/apicrm

Install dependencies

    composer install

Run the database migrations

    bin/console doctrine:migrations:migrate

In order to use the API you need to create an user

    bin/console fos:user:create test_user test@example.com 123456

Now, you are ready to use the API. You can checkout the API documentation in [here](doc/api-documentation.md)
  
