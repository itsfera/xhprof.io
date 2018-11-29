# Профилирование через xhprof

Качаем и собираем приблуду https://tideways.com/profiler/xhprof-for-php7
```
$ yum install gcc
$ yum install php-devel
$ git clone https://github.com/tideways/php-profiler-extension.git
$ cd php-profiler-extension
$ phpize
$ ./configure
$ make
$ sudo make install
```

Модуль подключаем в php.d
```extension=tideways_xhprof.so```

Не забываем включить модули PDO и PDO MySQL
```mv 20-pdo.ini.disabled 20-pdo.ini
mv 30-pdo_mysql.ini.disabled 30-pdo_mysql.ini
```

Отладка с помощью GET параметра
```ay[debug]=1```

Ставим аналитику отсюда в подпапку сайта
```git clone https://github.com/itsfera/xhprof.io.git```

Накатываем sql из папки, правим config.inc.php, прописываем параметры.
```
<?php
return array(
	'url_base' => 'https://lks-dev.mirea.ru/xhprof/',
	'url_static' => null, // When undefined, it defaults to $config['url_base'] . 'public/'. This should be absolute URL.
	'pdo' => new PDO('mysql:dbname=sitemanager;host=localhost;charset=utf8', 'bitrix0', '6-tnqTbB-NWrpEuCX8UR'),
);
?>
```

Если используется mysqli, то прописываем в php.ini
```pdo_mysql.default_socket=/var/lib/mysqld/mysqld.sock```

Ребутаем апача. В нужный скрипт перед шапкой:
```tideways_xhprof_enable(TIDEWAYS_XHPROF_FLAGS_MEMORY | TIDEWAYS_XHPROF_FLAGS_CPU);```

и в конце (пример)

```
$xhprof_data = tideways_xhprof_disable();
$config			= require $_SERVER["DOCUMENT_ROOT"].'/xdebug/xhprof/includes/config.inc.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/xdebug/xhprof/classes/data.php';
$xhprof_data_obj	= new \ay\xhprof\Data($config['pdo']);
$xhprof_data_obj->save($xhprof_data);
```

