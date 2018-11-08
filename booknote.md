### 记录常用的命令
- 创建模型 php artisan make:model Models/Cafe -m
- 数据库迁移 php artisan migrate
- 创建数据表 php artisan make:migration create_brew_methods_table
- 创建软连接 php artisan storage:link
- 创建数据自动填充类 php artisan make:seeder BrewMethodsSeeder
- 填充对应的数据表 php artisan db:seed --class=BrewMethodsSeeder   