# IP-to-Timezone
This is a method of freely and relatively efficiently figuring out the timezone of the user visiting your website. The PHP script is basically a free workaround because Geo-IP services that provide timezone information are not free.

It requires only a free account on [IP2Location.com](https://www.ip2location.com/) and [timezonedb.com](https://timezonedb.com/).

The results should be a timezone in [PHP's supported list](http://php.net/manual/en/timezones.php) allowing the use of the PHP function `date_default_timezone_set($timezone)` to synchronise timestamps with the user's time.

It is best practice to run the function only when the user's registers to be a part of the website due to the frequent API calls that would have to occur otherwise as well as the limited number of free API calls that timezonedb.com provide. Otherwise for situations with unregistered users it is best to figure out the timestamp once and store it in a session. Although due to the nature of the code I provide being essentially a free workaround it is not intended for high volume websites with large numbers of users.  
For a JS based solution that does not depend on APIs, registrations and databases but requires passing variables to the webserver, see [my gist](https://gist.github.com/sebastian-king/32040244877ac2985d8ee60b0091f01f).

See `example.php` for usage information.

**NOTE:** With PHP 7 the bcmath module is not included by default, it can be installed with `apt-get install php-bcmath`

Included in this Github is also a script and crontab for automatically updating the IP2Location database. IP2Location update their databases on the first of each month and therefore a crontab once a month is necessary to stay accurate with identifying timezones. For instructions on how to install this script please see the top of `cron/update-ip2location-db.php`.
Cron on 32-bit and 64-bit Linux, Unix and Windows is supported. Installation instructions for the updater can be found at `cron/update-ip2location-db.php`

Also please note that use of IP2Location's free (LITE) databases requires attribution, information of these requirements can be found at http://lite.ip2location.com/.
