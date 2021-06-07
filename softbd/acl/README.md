#Welcome to Softbd Role ACL
Installation step
- run composer command `composer require softbd/acl`
- run `php artisan vendor:publish --provider="Softbd\Acl\AclServiceProvider" --tag="config"`
- run `php artisan db:seed --class="Softbd\Acl\Seeders\TablePermissionKeySeeder"`


***Please create issue if facing any problem.**
