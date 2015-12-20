Yii2 Basic Ready
============================

Yii2 Basic Ready for your standard application.

LIBRARIES USED
--------------
	
- [dmstr/yii2-adminlte-asset](https://github.com/dmstr/yii2-adminlte-asset) (For Admin Template)
- [schmunk42/yii2-giiant](https://github.com/schmunk42/yii2-giiant) (For Model & CRUD generator)
- [kartik-v/yii2-widget-fileinput](https://github.com/kartik-v/yii2-widget-fileinput) (For File Upload)
	
FEATURES
--------
- Login with user from database.
- Register a Membership
- Logout
- User Menu
- Role Menu
- Dynamic Menu
- Dynamic RBAC


INSTALLATION
------------

Extract the archive file downloaded from [master.zip](https://github.com/febfeb/yii2-ready-basic/archive/master.zip) (approx 24MB) to a directory under the Web root.

Create a database named `yii2-basic-ready` and import an SQL file from directory `db/yii2-basic-ready.sql`

You can then access the application through the following URL:

~~~
http://localhost/yii2-basic-ready/web/
~~~

You can login using username `admin` with password `admin` (With Super Administrator privilege) or `user` with password `user` (With Regular User privilege). Or if you want to add more user, you can change it inside `user` table.

CONFIGURATION
----
You can change whether AdminLTE loads css and js from plugin theme or not inside `assets/AdminLtePluginAsset.php`