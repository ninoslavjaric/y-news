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