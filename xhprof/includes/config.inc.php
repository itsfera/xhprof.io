<?php
return array(
	'url_base' => 'https://lks-dev.mirea.ru/xhprof/',
	'url_static' => null, // When undefined, it defaults to $config['url_base'] . 'public/'. This should be absolute URL.
	'pdo' => new PDO('mysql:dbname=sitemanager;host=localhost;charset=utf8', 'bitrix0', '6-tnqTbB-NWrpEuCX8UR'),
);