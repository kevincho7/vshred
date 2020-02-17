## How to Install and Test

1. Clone the repository from: https://github.com/kevincho7/vshred.git

2. Inside your clonned local project folder, run composer install.

3. If you have an issue with Passport Oauth, run this command: php artisan passport:install

4. Edit the .env.example appropriately with your environment variables and rename it to .env file.

5. Run php artisan key:generate

6. Run php artisan migrate --seed

7. Run php artisan serve

8. Login Endpoint (Admin user): /api/login (Verb: POST; Body: email: kingservant@gmail.com; password: 123456)

9. For a standard user login: Use the above endpoint but with email: kevin@example.com; password: 123456

10. Register a new user endpoint: /api/register (Verb: POST; Body parameters: name, email, password, c_password)

11.  Upon successful creation of a new user, it will fire a Welcome email event.

12. List all users endpoint (only admin role user is allowed): /api/users (Verb: GET)

13. List all users with images: /api/users?include=images

14. List a user using a filter: /api/users?filter[email]=kingservant@gmail.com

15. Show a user detail: /api/users/{id} or /api/users/{id}?include=images

16. Rest of the methods can be accessed RESTfully.

17. Delete method is done with soft-delete.