## About Fixture Manager

fixture manager manages fixtures of certain teams, updates their leaderboards and simulates matches

You can run this project with docker. You need to run this command

```
docker-compose up -d
```

After run docker compose for making db migrations and seed need to be enter docker container with this command 
```
docker-compose exec app bash
```

After run docker compose for making db migrations and seed need to be enter docker container with this commands
```
composer install
php artisan migrate
php artisan db:seed
```
