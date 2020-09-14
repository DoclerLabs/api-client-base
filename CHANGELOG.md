# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [3.1.0] - 2020-09-07
### Added
- Support of 402 HTTP response code.

### Changed
- Refactor of the HTTP 4xx error handling part.

## [3.0.2] - 2020-09-07
### Fixed
- construct parameter order in `Response`

## [3.0.1] - 2020-09-03
### Fixed
- version in composer.json

## [3.0.0] - 2020-08-31
### Changed
- The response handling in `ResponseHandler`: Removed "data" key handling when handling payload.

## [2.0.1] - 2020-08-24
### Fixed
- The superkey "data" handling in ResponseHandler.

## [2.0.0] - 2020-07-28
### Changed
- Add HTTP headers support in the `ResponseHandler`.
- The `Response` class replace the array returned by the `ResponseHandler`.

## [1.0.0] - 2020-06-28
### Added
- Initial implementation of the library.
