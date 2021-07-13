@servers(['web' => 'deployer@t22.tfcis.org'])

@setup
    $repository = 'https://github.com/usspnaym/BE.git';
    $app_dir = '/var/www/SDGs';
@endsetup

@story('deploy')
    pull_repository
    run_composer
    run_npm
    migration
    optimize
    update_permissions
@endstory

@task('pull_repository')
    echo 'Cloning repository...'
    cd {{ $app_dir }}
    git pull
@endtask

@task('run_composer')
    echo 'Starting deployment ({{ $release }})...'
    cd {{ $app_dir }}
    composer install --prefer-dist --no-dev  --no-scripts --no-suggest --optimize-autoloader
@endtask

@task('run_npm')
    cd {{ $app_dir }}
    npm install
    npm run production
@endtask

@task('migration')
    cd {{ $app_dir }}
    php artisan migrate --seed
@endtask

@task('update_permissions')
    sudo setfacl -R -m u:www-data:rwx {{ $app_dir }}/storage {{ $app_dir }}/bootstrap/cache
@endtask

@task('optimize')
    cd {{ $app_dir }}
    php artisan optimize
@endtask
