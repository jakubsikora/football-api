@servers(['web' => 'jakub@jsikora.io' ])

@task('deploy', ['on' => 'web'])
    cd /var/www/football-api;
    git pull origin master;
@endtask
