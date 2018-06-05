# recruitment_task_S7HEALTH

This is simple application includes 3 options:
1) adding ten random codes,
2) displaying all codes,
3) removing codes if code exist in database (if code doesn't exist, the application display an error message )


Used technology: Symfony 4, MySQL

Install project - steps:
> composer install

Configure your .env file (create a database connection)

Create entity Code in database
> app/console doctrine:schema:create
> app/console doctrine:schema:update --force

Run server
> app/console server:run