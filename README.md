# Quai Antique

The restaurant Quai Antique is a web project which allows visitors and users to book a table through the website.
Visitors should provide all the necessary information while booking. Visitors can create an account 
and log in. Logged-in user will only need to provide the date and hour for their reservation. The admin will have full access to modify the contents of the website.

## Requirements
- Symfony LTS
- Php 8.0.31
- Composer
- MySQL 8.0

## Installation
1. Clone the repository:

    ```bash
    git clone [repository URL]
    ```
2. Install dependencies:

    Navigate to the project directory and run the following command:

    ```bash
    composer install
    ```

3. Configure the Database:

    Create the database by running the following commands:

    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

4. Start the Symfony Server:

    ```bash
    symfony server:start
    ```

---

## Logging in as Admin

To log in as an admin, use the following credentials:

Email: admin1@example.com   
Password: 123456

---

> Note: Make sure to run the following command to install the Symfony Runtime package, which is necessary for the project to run properly:

```bash
composer require symfony/runtime
