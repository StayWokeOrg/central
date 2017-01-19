FROM petecoop/laravel:onbuild

RUN php artisan migrate

CMD ["apache2-foreground"]
