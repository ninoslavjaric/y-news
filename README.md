# Yahoo portal #

* [Ninoslav Jaric](https://www.jaric.online/)

### Kako osvjezavati bazu? ###

Crob job pokrece periodicno skriptu koja osvjezava bazu iz feed-a.

```bash
*/15 * * * * /usr/bin/php /var/www/bravo.yf/console/runner bravo-news -c science
*/15 * * * * /usr/bin/php /var/www/bravo.yf/console/runner bravo-news -c tech
*/15 * * * * /usr/bin/php /var/www/bravo.yf/console/runner bravo-news -c world
*/15 * * * * /usr/bin/php /var/www/bravo.yf/console/runner bravo-news -c politics
*/15 * * * * /usr/bin/php /var/www/bravo.yf/console/runner bravo-news -c health

```

### MySQL Baza ###

> username: bravo
>
> password: bravo
>
> database: bravo

### Nginx configuration ###
```nginx
server {
	server_name bravo.yf bravo-test.com;
	root /var/www/bravo.yf/www;
	location / {
		try_files $uri /index.php$is_args$args;
	}
	location ~ ^/index\.php(/|$) {
		fastcgi_pass unix:/run/php/nino-fpm.sock;
		include fastcgi_params;
		fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
		fastcgi_param DOCUMENT_ROOT $realpath_root;
	}
	location ~ \.php$ {
		return 404;
	}
	error_log /var/www/bravo.yf/logs/error.log;
	access_log /var/www/bravo.yf/logs/access.log;
}
```
### Apache configuration ###
```apache
<VirtualHost *:8888>
	ServerName bravo.yf 
	ServerAlias bravo-test.com
	ServerAdmin webmaster@localhost
	DocumentRoot /var/www/bravo.yf/www
	<Directory /var/www/bravo.yf/www>
		AllowOverride None
		Order Allow,Deny
		Allow from All
		<FilesMatch ".+\.ph(p[3457]?|t|tml)$">
			SetHandler "proxy:unix:/run/php/nino-fpm.sock|fcgi://localhost"
	        </FilesMatch>
		<IfModule mod_rewrite.c>
			Options -MultiViews
			RewriteEngine On
			RewriteCond %{REQUEST_FILENAME} !-f
			RewriteRule ^(.*)$ /index.php [QSA,L]
		</IfModule>
	</Directory>
	ErrorLog /var/www/bravo.yf/logs/apache_error.log
	CustomLog /var/www/bravo.yf/logs/apache_access.log combined
</VirtualHost>
```