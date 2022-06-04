# DOCKER For LAMP Development 

## What this Dockerfile contains?
- Apache
- MySQL
- PHP
- phpMyAdmin

## How to run?
- Install docker and docker-compose
```bash
git clone https://github.com/ZXY-CC-3ag13/phpMyAdmin-MySQL-Docker.git
```
- cd phpMyAdmin-MySQL-Docker
- To start the container;
```bash
docker-compose up -d
```
> This will spin up a container with Apache, MySQL and PHP

> The persisent volume will be named mysql-test

> First run will take longer as it has to fetch all images

- Put your files in /src folder; it should show up in [localhost:8080](localhost:8080)
- To access phpMyAdmin, navigate to [localhost:5000](localhost:5000)

### To check if the server is running or not;

open [localhost:8080](localhost:8080)

### To list the current running containers;

```bash
docker-compose ps
```

### To stop the container

```bash
docker-compose down
```

### To list the volumes

```bash
docker volumes ls
```

### To remove the volume

```bash
docker volume rm phpMyAdmin-MySQL-Docker_sql-test
```
### To remove the images

```bash
# List all the images
docker image ls
# Remove the unneeded images
docker image rm namesOfImages
```

### Defaults

- MySQL password = secret
- phpMyAdmin user = root
- phpMyAdmin password = secret
- servername = mysql-server
