@servers(['web' => 'jakub@jsikora.io' ])

@task('deploy', ['on' => 'web'])
    cd /var/www/football-api;
    git pull origin master;
    php artisan down;
    composer install --prefer-dist;
    php artisan up;
@endtask
