# Back end Guide

1. require composer
2. into this floder
3. execute`$ composer install `
4. GET `http://yourdomain/gd/back_end/public/index.php`
5. f**k


## If you have problem in CROS
write these config in your `nginx.conf` file

at the `location .php` line

    add_header 'Access-Control-Allow-Origin' '*';
    add_header 'Access-Control-Allow-Credentials' 'true';
    add_header 'Access-Control-Allow-Methods' 'OPTION, POST, GET';
    add_header 'Access-Control-Allow-Headers' 'X-Requested-With, Content-Type';

restart the server.
