```bash
$ git clone player.git
$ cp .env.dist .env
$ nano .env
$ docker-compose up -d
$ docker network inspect bridge | grep "Gateway"
  "Gateway": "172.17.0.1"
$ docker-compose exec php bash

root@php:/var/www/symfony # composer install
root@php:/var/www/symfony # php bin/console d:d:c
root@php:/var/www/symfony # php bin/console d:s:u -f
root@php:/var/www/symfony # chmod -R 777 var/
root@php:/var/www/symfony # php bin/console d:f:l

```