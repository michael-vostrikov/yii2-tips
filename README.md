Yii 2 Tips
===============================

This project contains some code examples for Yii development.

Contents
-------------------
- Several attributes in one combined grid column
- Default sorting
- Fix for active items in navigation
- Table mapping
- Fix for correct work of TimestampBehavior
- Different formats for saving adn displaying value in DatePicker and DateTimePicker
- User timezone and timezone conversion for input values
- Scripts in view files

Installation
-------------------
```
composer install
php init
php yii migrate --migrationPath=@vendor/dektrium/yii2-user/migrations --interactive=0
php yii migrate --migrationPath=@vendor/yiisoft/yii2/web/migrations --interactive=0
php yii migrate --migrationPath=@yii/rbac/migrations --interactive=0
php yii migrate --interactive=0
```
