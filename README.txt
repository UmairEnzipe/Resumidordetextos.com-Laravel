NOTE: add "NOFOLLOW_NOINDEX=yes" in env file

step 1: composer update
step 2: composer dump-autoload
step 3: add db credentials in .env file
step 4: run "php artisan storage:link" in terminal
step 5: run "composer require doctrine/dbal" if not in composer.json
step 6: run "php artisan migrate:fresh"
step 7: run "php artisan db:seed"
step 8: run "php artisan optimize"
Hurrah! Ready to enjoy builtin dashboard just hit the admin hash route 