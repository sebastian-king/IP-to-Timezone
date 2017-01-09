<?php

# if you are running linux/unix, on some of the latest versions of PHP 7 it is requires to install the Zip library for PHP separately
# on debian based systems this can be achieved using `apt-get install php7.0-zip`
# on windows system, it may be required to enable the zip extension in your php.ini file.
# and also please note that there may be a different php.ini file for the PHP CLI that cron will be using rather than the one your webserver will use
#
# below is the line to be appended to your crontab configuration, the 3rd number should be any random number between 1 and 7
# because this is the day of the month that the script will use and should be randomised to avoid network congestion at the start of the month
# 45      23      <1-7>       *       *       php    /path/to/cron/update-ip2location-db.php
# make sure php is in $PATH or specify an absolute link
# then run crontab -e and install the crontab and viola, automatic updates should happen

$account_email = "<IP2Location.com registered e-mail address>";
$account_password = "<IP2Location.com registered password>";

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        if (strlen(decbin(~0)) == 64) {
                $bin = "download-64.exe";
        } else {
                $bin = "download.exe";
        }
} else {
        $bin = "download.pl";
}

chdir(/*dirname(__FILE__) . */"../include/ip2location-dbs/"); // change to extration location

exec(dirname(__FILE__) . "/$bin -package DB11LITEBIN -login \"{$account_email}\" -password \"{$account_password}\"", $output);
exec(dirname(__FILE__) . "/$bin -package DB11LITEBINIPV6 -login \"{$account_email}\" -password \"{$account_password}\"", $output);

// the two lines below are an alternative for the foreach loops at the end of the script for unix/linux-only systems that do not want
// to install the PHP library
//exec('for f in $(find ./ -name "*.ZIP"); do unzip -o "$f"; rm -- "$f"; done;', $output);
//exec('for f in $(find ./ ! -name "*.BIN" -type f); do rm -- "$f"; done;', $output);

foreach (new DirectoryIterator('./') as $fileinfo) {
        if($fileinfo->isDot()) continue;
        $filename = $fileinfo->getFilename();
        $filehandler = @fopen($filename, "r");
        if (!$filehandler) continue;
        $blob = fgets($filehandler, 5);
        if (strpos($blob, 'PK') !== false) { // should mean that this is a ZIP file
                $zip = new ZipArchive;
                $res = $zip->open($filename);
                if ($res === TRUE) {
                        $zip->extractTo('./');
                        $zip->close();
                }
        }
}

/* this can be used to save space, although this will remove the licence files
foreach (new DirectoryIterator('./') as $fileinfo) {
        if($fileinfo->isDot()) continue;
        $filename = $fileinfo->getFilename();
        if (!preg_match("/\.bin$/i", $filename)) {
                unlink($filename);
        }
}
*/
