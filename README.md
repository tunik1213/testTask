
# Todo List API
It is a simple HTTP service designed for managing tasks. This API allows users to perform basic CRUD (Create, Read, Update, Delete) operations on tasks. Also it provides a list of tasks that can be filtered and ordered in different ways. All avaliable methods of the API are described in the [OpenAPI specification](OpenAPI.yaml)



## Running project with docker
1. Clone the repository:
```bash
$ git clone https://github.com/tunik1213/testTask
```
2. Set up environment and proper permissions
```bash
$ cd testTask/
$ cp .env.docker .env
$ chmod -R 777 storage
```
3. Build up a docker container
```bash
$ docker-compose up -d --build
```
4. Install dependencies
```bash
$ docker-compose exec app composer install
```
5. Run migrations and seeding
```bash
$ docker-compose exec app php artisan migrate --seed
```
Now the Http service should be avaliable on your server on port 8000. You can check whether it works quering 
```
http://<your-server>:8000/test
```





## Usage

First things first, you need to register a new user in order to get your access token. You can do it by querying 
```
/api/registerUser
```
Then you can call any of the available /api/tasks methods using that token for the Bearer authentication
