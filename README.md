# symfony-5.4.x-dev

### How to use
```sh
docker-compose up
docker-compose exec php symfony composer install
docker-compose exec php symfony console doctrine:database:create --if-not-exists
docker-compose exec php symfony console doctrine:migrations:migrate
docker-compose exec php symfony console doctrine:schema:update --force
docker-compose exec php symfony console doctrine:fixtures:load
```
