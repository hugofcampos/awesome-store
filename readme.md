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
