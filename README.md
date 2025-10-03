# Microservices in PHP + Docker
Example of microservices in PHP + Docker

This repository contains a small project to see how the microservices work. 

You will need to install Docker (Docker compose) to launch the diferents services to start and to test it.

## About the script

This script is launch three services. The first one is the main app, the second one is a microservice to manage users, and the third one is a microservice to manage the sending of emails.

When you start the project, you can see how the main app sends request to the other services to get information and also how the backend microservices interact with each other.

This code is develop in PHP to the backend `microservices` and HTML + JS + CSS to the main app.

## Services

### Main app
  - Apache
  - HTML, Javascript, CSS
### Users microservice
  - Apache
  - PHP 7.4
  - MySQL
### Emails microservice



  
