<?php
require_once("include/IP2Location.php");
$ip = $_SERVER['REMOTE_ADDR'];
if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
	$db = new \IP2Location\Database("include/IP2LOCATION-LITE-DB11.BIN", \IP2Location\Database::FILE_IO);
} else if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
	$db = new \IP2Location\Database("include/IP2LOCATION-LITE-DB11.IPV6.BIN", \IP2Location\Database::FILE_IO);
} else {
	$timezone = "UTC";
}
$ipinfo = $db->lookup($_SERVER['REMOTE_ADDR'], \IP2Location\Database::ALL);
$tzdb = file_get_contents("http://api.timezonedb.com?key=<TIMEZONEDB_API_KEY>&lat={$ipinfo['latitude']}&lng={$ipinfo['longitude']}&format=json");
$timezone = json_decode($tzdb);
$timezone = $timezone->zoneName;
if (!in_array($timezone, timezone_identifiers_list())) {
	$timezone = "UTC";
}
echo "<pre>";
echo "Timezone: " . var_export($timezone, true) . PHP_EOL;

date_default_timezone_set($timezone);

echo "The date/time where you are is: " . date("F j, Y, g:i a T");
