<?php
$server = 'jakub@jsikora.io';
$project_dir = '/var/www/football-api';
?>

@servers(['web' => {{ $server }}])

@macro('deploy', ['on' => 'web'])
    fetch_repo
    enable_maintenance_mode
    run_composer
    migration
    disable_maintenance_mode
@endmacro

@task('fetch_repo')
    cd {{ $project_dir }};
    git pull origin master;
@endtask

@task('run_composer')
    composer install --prefer-dist;
@endtask

@task('enable_maintenance_mode')
    {{-- php artisan down -}}
@endtask

@task('migration')
    {{-- php artisan migrate -}}
@endtask

@task('disable_maintenance_mode')
    {{-- php artisan up -}}
@endtask
