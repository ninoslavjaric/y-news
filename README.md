# Yahoo portal #

* [Ninoslav Jaric](https://www.jaric.online/)

### Kako osvjezavati bazu? ###

Crob job pokrece periodicno skriptu koja osvjezava bazu iz feed-a.

```bash
*/15 * * * * /usr/bin/php /pathToProject/console/runner bravo-news -c science
*/15 * * * * /usr/bin/php /pathToProject/console/runner bravo-news -c tech
*/15 * * * * /usr/bin/php /pathToProject/console/runner bravo-news -c world
*/15 * * * * /usr/bin/php /pathToProject/console/runner bravo-news -c politics
*/15 * * * * /usr/bin/php /pathToProject/console/runner bravo-news -c health

```

### MySQL Baza ###

> username: bravo
>
> password: bravo
>
> database: bravo

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
```apache
<VirtualHost *:80>
	ServerName bravo.yf 
	ServerAlias bravo-test.com
	ServerAdmin webmaster@localhost
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