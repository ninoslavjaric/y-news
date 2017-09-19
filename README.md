# Yahoo portal #

* [Ninoslav Jaric](http://www.jaric.online/)

### Postavka ###
#### Kreiranje baze ####
```mysql
CREATE DATABASE `bravo` CHARSET=utf8 COLLATE=utf8_general_ci;
```
#### Postavke tabela ####
```bash
/usr/bin/php /pathToProject/console/runner setup
```
#### Inicijalni load vijesti ####
```bash
/usr/bin/php /pathToProject/console/runner bravo-news -c science
/usr/bin/php /pathToProject/console/runner bravo-news -c tech
/usr/bin/php /pathToProject/console/runner bravo-news -c world
/usr/bin/php /pathToProject/console/runner bravo-news -c politics
/usr/bin/php /pathToProject/console/runner bravo-news -c health
```

### Osvjezavanje baze ###

Crob job pokrece dva puta dnevno skriptu koja osvjezava bazu iz feed-a.

```bash
0 */12 * * * /usr/bin/php /pathToProject/console/runner bravo-news -c science
0 */12 * * * /usr/bin/php /pathToProject/console/runner bravo-news -c tech
0 */12 * * * /usr/bin/php /pathToProject/console/runner bravo-news -c world
0 */12 * * * /usr/bin/php /pathToProject/console/runner bravo-news -c politics
0 */12 * * * /usr/bin/php /pathToProject/console/runner bravo-news -c health

```

### Postojece postavke MySQL Baze ###

###### config/database.php
```php
return [
    "mysql" => [
        "host"    => "127.0.0.1",
        "username"=> "bravo",
        "password"=> "bravo",
        "dbname"  => "bravo",
        "port"    => "3306"
    ],
    "redis" => [
        "host"  => "127.0.0.1",
        "port"  => "6379",
        "dbname"    =>  "1"
    ]
]
```

### Nginx konfiguracija ###
```nginx
server {
	server_name bravo.yf bravo-test.com;
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
### Apache konfiguracija ###
###### Modules enabled: proxy_fcgi, rewrite
```apache
<VirtualHost *:80>
	ServerName bravo.yf 
	ServerAlias bravo-test.com
	
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

#### Google analytics i Facebook app ####
###### config/app.php
Kljucevi koji bi mogli biti zanimljivi za izmjene su:

- debug
- fbAppId   
- google-analytics
- contact-email

```php
return [
    'debug' =>  true,
    // **
       * Something else
       * /
    'fbAppId'   =>  "136678420285291",
    'google-analytics'  =>  "UA-68703861-6",
    'contact-email'     =>  "ninoslavjaric@gmail.com",
];
```