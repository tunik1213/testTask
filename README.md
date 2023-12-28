
# Todo List API
It is a simple HTTP service designed for managing tasks. This API allows users to perform basic CRUD (Create, Read, Update, Delete) operations on tasks. Also it provides a list of tasks that can be filtered and ordered in different ways. All avaliable methods of the API are described in the [OpenAPI specification](OpenAPI.yaml)



## Running project with docker
1. Clone the repository:
```
git clone https://github.com/tunik1213/testTask
```
2. Set up environment and proper permissions
```
cd testTask/
```
```
cp .env.docker .env
```
```
chmod -R 777 storage
```
3. Build up a docker container
```
$ docker-compose up -d --build
```
4. Install dependencies
```
docker-compose exec app composer install
```
5. Run migrations and seeding
```
docker-compose exec app php artisan migrate --seed
```
Now the HTTP service should be avaliable on your server on port 8000. You can check whether it works quering 
```
http://<your-server>:8000/test
```


## Usage

#### 1. Register a New User:

Before using the Task Management API, you need to register a new user to obtain an access token. This can be done by querying
```
/api/registerUser
```
The response will contain the access token.

#### 2. Accessing Task Management API:

Use the obtained access token for Bearer authentication querying any of the avaliable /api/tasks methods according to [specification](OpenAPI.yaml)
