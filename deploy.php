<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'QuiniDepor');

// Project repository
set('repository', 'https://github.com/FranLeston/depor_predictor');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

host('root@157.230.107.10')
    ->set('deploy_path', '/var/www/html');

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);

// Hosts

host('fran@165.22.66.154')
    ->set('deploy_path', '/var/www/quinidepor')
    ->set('branch', 'master');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

task('deploy:config', function () {
    // For arguments
    $stage = null;
    if (input()->hasArgument('stage')) {
        $stage = input()->getArgument('stage');
        write('Remove shared environment file');
        run('rm {{deploy_path}}/shared/.env');
        write('Copying {{release_path}}/.env.' . $stage . ' as config file...');
        run('cp {{release_path}}/.env.' . $stage . ' {{deploy_path}}/shared/.env');
    } else {
        write('No config file copied!');
    }
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');
