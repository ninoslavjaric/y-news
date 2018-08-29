# Yahoo portal #

* [Ninoslav Jaric](http://www.jaric.online/)
* [Yahoo portal](http://y-news.online/)

### Setup ###
#### Db creation ####
```mysql
CREATE DATABASE `bravo` CHARSET=utf8 COLLATE=utf8_general_ci;
```
#### Tables setup ####
App initialization is being done by running following commands

```bash
/usr/bin/php /pathToProject/console/runner setup
```
#### Initial load of news ####
```bash
/usr/bin/php /pathToProject/console/runner bravo-news -c science
/usr/bin/php /pathToProject/console/runner bravo-news -c tech
/usr/bin/php /pathToProject/console/runner bravo-news -c world
/usr/bin/php /pathToProject/console/runner bravo-news -c politics
/usr/bin/php /pathToProject/console/runner bravo-news -c health
```

### Data refresh ###

Crontab refreshes the data two times per day by executing script that pulls feed

```bash
0 */12 * * * /usr/bin/php /pathToProject/console/runner bravo-news -c science
0 */12 * * * /usr/bin/php /pathToProject/console/runner bravo-news -c tech
0 */12 * * * /usr/bin/php /pathToProject/console/runner bravo-news -c world
0 */12 * * * /usr/bin/php /pathToProject/console/runner bravo-news -c politics
0 */12 * * * /usr/bin/php /pathToProject/console/runner bravo-news -c health

```

### Existing MySQL data config ###

###### config/database.php
```php
return [
    "mysql" => [
        "host"    => "127.0.0.1",
        "username"=> "username",
        "password"=> "pass",
        "dbname"  => "database",
        "port"    => "3306"
    ],
    "redis" => [
        "host"  => "127.0.0.1",
        "port"  => "6379",
        "dbname"    =>  "1"
    ]
]
```

### Nginx config ###
```nginx
server {
	server_name y-news.online;
	root /pathToProject/www;
	location / {
		try_files $uri /index.php$is_args$args;
	}
	location ~ ^/index\.php(/|$) {
		fastcgi_pass unix:/run/php/socketName.sock;
		include fastcgi_params;
		fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
		fastcgi_param DOCUMENT_ROOT $realpath_root;
	}
	location ~ \.php$ {
		return 404;
	}
	error_log /pathToProject/logs/error.log;
	access_log /pathToProject/logs/access.log;
}
```
### Apache config ###
###### Modules enabled: proxy_fcgi, rewrite
```apache
<VirtualHost *:80>
	ServerName y-news.online 
	ServerAlias www.y-news.online
	
	DocumentRoot /pathToProject/www
	<Directory /pathToProject/www>
		AllowOverride None
		Order Allow,Deny
		Allow from All
		<FilesMatch ".+\.ph(p[3457]?|t|tml)$">
			SetHandler "proxy:unix:/run/php/socketName.sock|fcgi://localhost"
	        </FilesMatch>
		<IfModule mod_rewrite.c>
			Options -MultiViews
			RewriteEngine On
			RewriteCond %{REQUEST_FILENAME} !-f
			RewriteRule ^(.*)$ /index.php [QSA,L]
		</IfModule>
	</Directory>
	ErrorLog /pathToProject/logs/apache_error.log
	CustomLog /pathToProject/logs/apache_access.log combined
</VirtualHost>
```

#### Google analytics & Facebook app ####
###### config/app.php
Keys interesting to change are:

- debug
- fbAppId   
- google-analytics
- contact-email
- reCaptcha

```php
return [
    'debug' =>  true,
    // **
       * Something else
       * /
    'fbAppId'   =>  "136678420285291",
    'google-analytics'  =>  "UA-XXXXXXXX-X",
    'contact-email'     =>  "username@example.com",
    'reCaptcha' =>  [
        'secret'    =>  "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
        'key'       =>  "yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy",
    ],
];
```
