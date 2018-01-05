# NHTSA NCAP 5 Star Safety Ratings API consumer

## Requirements

### PHP

This project uses Lumen 5.5 so it has a few requirements:

- PHP 7.0+
- openssl
- pdo
- mbstring

### Web server

Apache 2.4+ or NGINX 1.13+

## Configuration

### Apache with PHP-FPM

```
<VirtualHost *:8080>
    ServerName sub.domain.com

    DocumentRoot /path/to/public


    ProxyPassMatch ^/(.*\.php)$ fcgi://127.0.0.1:9000/path/to/public/$1

    DirectoryIndex /index.php index.php

    <Directory /path/to/public>
        AllowOverride all
    </Directory>
</VirtualHost>
```

## Installation

- Clone this repository;
- Run `composer install` in the root dir.

## Debugging

To enable debug mode, add the following to the `.env` file in the root dir:

```
APP_DEBUG=true
```

The `.env` file contains a required parameter `NHTSA_WEBAPI_BASE_URL` which can be modified to point to a fake API.

## Logging

Log messages are stored at `storage/logs/lumen.log` -- make sure this file is writeable.
