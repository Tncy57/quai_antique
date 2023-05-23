# quai_antique

The restaurant Quai Antique is a web project which allows visitors and users book a table through the web-site.
The visitors should provide all the necessary information while booking. The visitor can create an account 
and log in. Logged-in user will only provide date and hour. The admin will have all access to modify the content of the website.

## Requirements
-Symfony Lts
- Php 8.0.31
- Composer
- MySQL 8.0

## Installation
1. Clone the repository:
```bash
git clone [repository URL]
```
2.Install dependencies:
```bash
cd [project directory]
```
```bash
composer install
```
3. Configure the Database
```bash
php bin/console doctrine:database:create
```
```bash
php bin/console doctrine:migrations:migrate
```
```bash
symfony server:run
```
"" To log in as admin:
Email: admin1@example.com   
Password: 123456
