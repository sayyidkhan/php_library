## how to check what is inside the docker image
```bash
## view image
docker image ls
## view volume
docker volume ls
```

## view existing running containers on your computer
```bash
docker ps -a
```

## how to build docker app
```bash
docker build -t my-node-app:v1 .
```

## how to run docker app
```bash
docker run -p 3000:3000 my-node-app:v1
```

## stop all docker containers
```bash
docker stop CONTAINER_ID
```

## remove all docker containers
```bash
docker rm CONTAINER_ID
```

## navigate into the docker directory
```bash
docker exec -it CONTAINER_ID sh

## how to exit
exit
```

## how to run the db app
```bash
docker run --name some-postgres -e POSTGRES_USER=test POSTGRES_PASSWORD=secret POSTGRES_DB=foobar -p 5432:5432 -d postgres
```

## how to use docker with CLI
```bash
docker --help
docker build --help
```

## how to run / stop docker compose
```bash
## bring up docker compose
docker compose up
## bring up docker compose (run it in detached mode)
docker compose up -d
## bring down docker compose
docker compose down
## docker compose (process) - list all the processes
docker compose ps
```

## docker compose logs
```bash
docker compose logs
```