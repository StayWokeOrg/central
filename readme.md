# StayWoke Central

[![Codeship Status for StayWokeOrg/central](https://codeship.com/projects/a937ac20-b91c-0134-e6c5-166255a25182/status?branch=development)](https://codeship.com/projects/194895)

Central repository for all contact information gathered from various apps.

### Additional resources

* [Api documentation](docs/api.md)

### Requirements

* PHP >= 5.6.4
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* A [supported relational database](http://laravel.com/docs/5.3/database#introduction) and corresponding PHP extension
* [Composer](https://getcomposer.org/download/)

### Installation

1. (Optionally) [Fork this repository](https://help.github.com/articles/fork-a-repo/)
2. Clone the repository locally
3. [Install dependencies](https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies) with `composer install`
4. Copy [`.env.example`](https://github.com/staywokeorg/central/blob/master/.env.example) to `.env` and modify its contents to reflect your local environment.
5. [Run database migrations](http://laravel.com/docs/5.3/migrations#running-migrations). If you want to include seed data, add a `--seed` flag.

    ```bash
    php artisan migrate
    ```
6. Configure a web server, such as the [built-in PHP web server](http://php.net/manual/en/features.commandline.webserver.php), to use the `public` directory as the document root.

    ```bash
    php -S localhost:8080 -t public
    ```

     Or use [Laravel Valet](https://laravel.com/docs/5.3/valet)
7. Run tests with `./vendor/bin/phpunit`.
