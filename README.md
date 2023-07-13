
## Project Setup
Follow these steps to set up and run the project:

1- Make a copy of the environment file
```
cp .env.example .env
```

2- Start the Docker containers in detached mode
```
docker-compose up -d
```

3- Install dependencies and run the development build
```
npm i && npm run dev
```

4- Run database migrations and seed the database with initial data
```
php artisan migrate --seed
```
