<?php

# install
# 45      23      <1-7>       *       *       php    /path/to/cron/update-ip2location-db.php
# make sure php is in $PATH or specify an absolute link

$account_email = "<IP2Location.com registered e-mail address>";
$account_password = "<IP2Location.com registered password>";

chdir(dirname(__FILE__) . "../include/ip2location-dbs/");

exec("../../cron/download.pl -package DB11LITEBIN -login \"{$account_email}\" -password \"{$account_password}\"", $output);
exec("../../cron/download.pl -package DB11LITEBINIPV6 -login \"{$account_email}\" -password \"{$account_password}\"", $output);
exec('for f in $(find ./ -name "*.ZIP"); do unzip -o "$f"; rm -- "$f"; done;');
exec('for f in $(find ./ ! -name "*.BIN" -type f); do rm -- "$f"; done;');
