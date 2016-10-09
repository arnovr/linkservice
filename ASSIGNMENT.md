## Link-Service - Specification
Create a RESTful PHP service which is able to transform a http link into a minimized and trackable link. 
The service should be able to track a click on such a generated link and also redirect the user to the initial URL. The service should run within a Docker Container.

Example: https://www.url.com/info/versicherung/document/some/very/long/path will become https://link.url.com/abc123

### Technical Requirements
- Zend Framework 2/3 or Symfony 2/3
- PHP7
- MySQL
- Docker

### Code Requirements
- PSR-2 Code
- Proper Documentation

### Functional Requirements
- RESTful API (CRUD)
- Link Tracking (e.g. referral) and Redirection