FROM petecoop/laravel:onbuild

CMD php artisan migrate && apache2-foreground
