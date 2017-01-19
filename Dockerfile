FROM petecoop/laravel:onbuild

RUN php artisan migrate
