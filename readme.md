# Awesome Store

## Running app

Requirements

- [Docker](https://www.docker.com/)

Just run:

```bash
$ docker-compose build
$ docker-compose up -d
```

Then, you need to set the application up.

Installing app dependencies

```bash
docker exec web bash  -c "php bin/console server:start 0.0.0.0:8000"
```

Running app

```bash
docker exec web bash  -c "php bin/console server:run 0.0.0.0:8000"
```

Access http://localhost:8000

### Check production version

Because it's only a test application, the default environment mode is set to "dev".

But it's possible do turn this environment to production. It may be usefull to test error pages, for example.

First, you need to clean production caches:

```bash
docker exec web bash  -c "php bin/console cache:clear --env=prod"
```

Then, modify the "app/.env" file, seting APP_ENV to "prod".

```.env
APP_ENV=prod
```
