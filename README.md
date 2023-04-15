<p align="center"><a href="https://techuplabs.com/" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## About Techup Labs Assignment

- Create REST APIs to perform the following transactions:
- User Login & Registration
- All further APIs should have token-based authentication. You are free to use Passport/JWT/Sanctum, etc.
- Create a task with Multiple Notes (pass notes in array format) in a single request. Only logged in     users can hit this request
- Retrieve all the tasks with Notes. Only logged in users can hit this request
- Order: Priority "High" First, Maximum Count of Notes
- Filter: filter[status], filter[due_date], filter[priority], filter[notes]: Retrieve tasks which have minimum one note attached

## Implementation

 - Enitre DB has been created using migration(php artisan migrate)
 - Use of Factories in the seeders has been implemented (Use command php artisan db:seed)
 - For Authentication of users Laravel Sanctum has been used.(With apis for login, register, logout).
 - Models(Task, Note) with relationship of One Task has many Notes.
 - Dedicated query string filter of Laravel has been used for creating different filter for Tasks fetch api. ('priority_order', 'priority', 'status', 'due_date', 'note')
 - Laravel FormRequest has been used for validation in any POST api.
 - A global middleware has been CORS to solve the cors issue in the application.
 - A dedicated transformer abstract class has been created to be user for model specific transformers to fetch a transformed pagination collection, collection and object.

### Api

- **[Register](http://localhost:8000/api/register)**
- **[Login](http://localhost:8000/api/login)**
- **[Logout](http://localhost:8000/api/logout)**
- **[Fetch Tasks](http://localhost:8000/api/tasks)**
- **[Create Task](http://localhost:8000/api/tasks)**