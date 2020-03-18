# Psinder

## How to run Psinder/
Run `make initial-setup`. It will run docker-compose, install deps and prepare databases.

To start it without recreating everything, use `make docker-compose-up`.

## Makefiles
Each part of the system should have its own Makefile.

Some common parts can be defined in root dir's `Makefile`, `Makefile-php`, etc.

In some cases service-specific makefile has to define configuration variabless before including common Makefile, like here:
```makefile
PROJECT_DIR = ../

include ../Makefile

PHP_SERVICE=adoption-php

include ../Makefile-php
```

## E2E tests
To run e2e tests use `make e2e`.
 
## Components
### PhpSharedKernel
Shared library. Includes basic abstraction, test helpers, etc.
### Adoption
Implements adoption domain.
### Security
Manages users - registration, login, etc
### e2e-tests
Experiment about introducing clean e2e test using behat.
### frontend
Probably broken, initial try to implement basic ui for registration
