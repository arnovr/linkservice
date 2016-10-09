[![Build Status](https://travis-ci.org/arnovr/linkservice.svg?branch=master)](https://travis-ci.org/arnovr/linkservice)
# Link-Service

## prerequisites
- docker
- composer install (https://getcomposer.org/download/)
- docker compose (https://docs.docker.com/compose/install/)
- ant (http://ant.apache.org/) if you want to run the tests

## Running the service
````
./bin/run
````

## Testing the service
````
ant
````

## Using the service
### Create trackable link:
POST /api/link

Body:
````
{
  "referrer": "referer/path",
  "link" : "https://www.url.com/info/document/some/very/long/UPDATE"
}
````

### Updating a trackable link
Put /api/link

Body:
````
{
  "referrer": "referer/path",
  "link" : "https://www.url.com/info/document/some/very/long/UPDATE"
}
````

### Deleting a trackable link
DELETE /api/link

Body:
````
{
  "referrer": "referer/path"
}
````
