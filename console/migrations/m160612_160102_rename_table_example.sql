/* This file is just example of how to rename tables in existing project */
/* If you have cloned this project and run migrations, you don't need to execute this query, because the tables are created with correct names */


/* up */

RENAME TABLE `migration` TO `__db__migration`;
RENAME TABLE `session` TO `__web__session`;
RENAME TABLE `auth_assignment` TO `__rbac__auth_assignment`;
RENAME TABLE `auth_item` TO `__rbac__auth_item`;
RENAME TABLE `auth_item_child` TO `__rbac__auth_item_child`;
RENAME TABLE `auth_rule` TO `__rbac__auth_rule`;
RENAME TABLE `user` TO `__user__user`;
RENAME TABLE `profile` TO `__user__profile`;
RENAME TABLE `token` TO `__user__token`;
RENAME TABLE `social_account` TO `__user__social_account`;


/* down */

RENAME TABLE `__db__migration` TO `migration`;
RENAME TABLE `__web__session` TO `session`;
RENAME TABLE `__rbac__auth_assignment` TO `auth_assignment`;
RENAME TABLE `__rbac__auth_item` TO `auth_item`;
RENAME TABLE `__rbac__auth_item_child` TO `auth_item_child`;
RENAME TABLE `__rbac__auth_rule` TO `auth_rule`;
RENAME TABLE `__user__user` TO `user`;
RENAME TABLE `__user__profile` TO `profile`;
RENAME TABLE `__user__token` TO `token`;
RENAME TABLE `__user__social_account` TO `social_account`;
