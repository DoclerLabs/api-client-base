# OpenAPI SDK generator - Api Client Base

This library provides the base classes and interfaces for the generated clients made by [api-client-generator](https://github.com/DoclerLabs/api-client-generator).

## Description
Base classes of the generated client are:

- ClientFactory - responsible for creating the client object with all of the necessary dependencies.
- Client - main class containing all of the methods needed to send API requests according to specification.
- Request - encapsulates incoming request parameters.
- RequestMapper - translates the request parameters suitable for the base Guzzle client.
- ResponseHandler - decides the appropriate response based on the returned response status code (specific exception on the error status code).
- ResponseMapperRegistry - simple container for the response mappers.
- ResponseMapper - maps raw response into the easy-to-use schema objects.
- Schema - entity objects within the scope of the client (e.g. Post).

This base client repository provides the static, reusable parts of this client structure: RequestMapper, ResponseHandler, Exceptions, etc.

## Development
 
### Setup
 
    composer install
 
### Testing
 
    vendor/bin/phpunit
 
See test reports in `test-reports` directory.

## Contributing
 
Create a branch and open PR.
 
All notable changes to this project are documented in the [CHANGELOG.md](CHANGELOG.md) file, it must be maintained.
 
The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).
