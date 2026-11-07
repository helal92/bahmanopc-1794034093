<?php
$ini = "/tmp/sitefile_opcache_settings.ini";
file_put_contents($ini, "opcache.enable=1\nopcache.memory_consumption=256\nopcache.max_accelerated_files=60000\nopcache.revalidate_freq=60\nopcache.validate_timestamps=1\n");
echo shell_exec('plesk bin site --update-php-settings sitefile.bahman.ir -settings '.escapeshellarg($ini).' 2>&1');
echo "\n--- show ---\n";
echo shell_exec('plesk bin site --show-php-settings sitefile.bahman.ir 2>&1 | grep -i opcache');
// rebuild/reload
echo shell_exec('plesk bin php_handler --reread 2>&1 | tail -5');
echo shell_exec('plesk sbin phpinimng --generate-all-web 2>&1 | tail -10');
// try signal as root via sudo
echo shell_exec('sudo -n kill -USR2 $(cat /opt/plesk/php/7.4/var/run/php-fpm.pid) 2>&1; echo sudo_usr2:$?');
echo "\nload=".trim(@file_get_contents('/proc/loadavg'))."\n";
echo 'fpm_sitefile='.trim(shell_exec('ps -eo cmd | grep "[p]hp-fpm: pool sitefile" | wc -l'))."\n";
echo 'flag='.(is_file('/var/www/vhosts/siteapi.bahman.ir/httpdocs/file_manager/.FAST_MODE')?'on':'off')."\n";
