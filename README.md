# IP-to-Timezone
This is a method of freely and relatively efficiently figuring out the timezone of the user visiting your website. This script is basically a workaround because GeoIP services that provide timezone information are not free.

It requires only a free account on IP2Location.com and timezonedb.com.

The results should be a timezone in PHP's supported list (http://php.net/manual/en/timezones.php) allowing the use of the PHP function `default_date_timezone_set($timezone)` to synchronise timestamps with the user's time.

It is best practice to run the function only when the user's registers to be a part of the website due to the frequent API calls that would have to occur otherwise as well as the limited number of free API calls that timezonedb.com provide.

See `example.php` for usage information.
