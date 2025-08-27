
# Application

___
[![Latest Version on Packagist](https://img.shields.io/packagist/v/mulertech/application.svg?style=flat-square)](https://packagist.org/packages/mulertech/application)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mulertech/application/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mulertech/application/actions/workflows/tests.yml)
[![GitHub PHPStan Action Status](https://img.shields.io/github/actions/workflow/status/mulertech/application/phpstan.yml?branch=main&label=phpstan&style=flat-square)](https://github.com/mulertech/application/actions/workflows/phpstan.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/mulertech/application.svg?style=flat-square)](https://packagist.org/packages/mulertech/application)
[![Test Coverage](https://raw.githubusercontent.com/mulertech/application/main/badge-coverage.svg)](https://packagist.org/packages/mulertech/application)
___

This application run request handlers with request message received and produce a response message

___

## Installation

###### _Two methods to install Application package with composer :_

1.
Add to your "**composer.json**" file into require section :

```
"mulertech/application": "^1.0"
```

and run the command :

```
php composer.phar update
```

2.
Run the command :

```
php composer.phar require mulertech/application "^1.0"
```

___

## Usage

<br>

###### _Initialize the application with one or more middlewares :_

```
$app = new Hub([ControllerMiddleware::class]);
```

<br>

###### _Find the project path (It can be used in all your project) :_

```
$projectPath = $app::projectPath();
```
 > * _The application need the composer.json file in the project folder to determine its path._

<br>

###### _Load env file into the project path :_

```
$app::loadEnv($app::projectPath() . DIRECTORY_SEPARATOR . '.env.local');
```

<br>

###### _Load the parameters of the yaml files into the config path (recursively) into the container :_

```
$app::loadConfig($container, $app::projectPath() . DIRECTORY_SEPARATOR . 'config');
```

<br>

###### _Run the application with the request given and produce a response message :_

```
$response = $app->run(ServerRequest::fromGlobals());
```
