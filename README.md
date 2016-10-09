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

## Choices:
### Redis
It is faster than MySQL. Especially when redirecting, speed is essential. 
Depending on redis setup, the data loss could be manageable.

### MySQL
I used MySQL purely for tracking clicks, not for actual url lookup, I felt redis was more suited for that job.
I wouldn't use MySQL at all in this specific case, I would preferably put the click events in kafka or some other event store.

### Symfony 3
Mainly a framework where I am familiar with.

### Trackable link only by path
The requirements did not state it should support multiple hosts or subdomains. 
Therefor path should be sufficient.

### Doctrine
Doctrine has been removed, just for storing a few click events, doctrine would be bloat. 
PDO is alot more suited on such a simple task.

### Docker compose
It is easier.....