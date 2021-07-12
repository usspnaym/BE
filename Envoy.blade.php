@servers(['web' => 'deployer@t22.tfcis.org'])

@setup
    $repository = 'ssh://git@github.com/usspnaym/BE.git';
    $app_dir = '/var/www/laravel-envoy';
    $releases_dir = '/var/www/SDGs/releases';
    $release = date('YmdHis');
    $new_release_dir = $releases_dir.'/'.$release;
@endsetup

@story('deploy')
    clone_repository
    run_composer
    update_symlinks
    update_permissions
@endstory

@task('clone_repository')
    echo 'Cloning repository...'
    [ -d {{ $releases_dir }} ] || mkdir {{ $releases_dir }}
    git clone --depth 1 {{ $repository }} {{ $new_release_dir }}
@endtask

@task('run_composer')
    echo 'Starting deployment ({{ $release }})...'
    cd {{ $new_release_dir }}
    composer install --prefer-dist --no-dev  --no-scripts --no-suggest --optimize-autoloader
@endtask

@task('update_symlinks')
    echo 'Linking storage directory...'
    rm -rf {{ $new_release_dir }}/storage
    ln -nfs {{ $app_dir }}/storage storage.tmp
    mv -fT storage.tmp {{ $new_release_dir }}/storage

    echo 'Linking .env file...'
    ln -nfs {{ $app_dir }}/.env .env.tmp
    mv -fT .env.tmp {{ $new_release_dir }}/.env

    echo 'Linking current release...'
    ln -nfs {{ $new_release_dir }} current.tmp
    mv -fT current.tmp {{ $app_dir }}/current
@endtask

@task('update_permissions')
    sudo setfacl -R -m u:www-data:rwx {{ $new_release_dir }}/storage {{ $new_release_dir }}/bootstrap/cache
@endtask
