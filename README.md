# Профилирование через xhprof
# Профилирование через xhprof
<p>Ставим приблуду https://tideways.com/profiler/xhprof-for-php7</p> 

<code>$ yum install gcc
$ yum install php-devel
$ git clone https://github.com/tideways/php-profiler-extension.git
$ cd php-profiler-extension
$ phpize
$ ./configure
$ make
$ sudo make install
</code>


<p>Модуль подключаем в php.d</p>

<code>extension=tideways_xhprof.so
</code>

<p>Не забываем включить модули PDO и PDO MySQL</p>
<code>mv 20-pdo.ini.disabled 20-pdo.ini
mv 30-pdo_mysql.ini.disabled 30-pdo_mysql.ini
</code>

<p>Отладка с помощью GET параметра</p>
<code>ay[debug]=1</code>

<p>Ставим аналитику отсюда в подпапку сайта</p>

<code>https://github.com/itsfera/xhprof.io.git</code>

<p>Накатываем sql из папки, правим config.inc.php, прописываем параметры. </p>
<code>
	<?php
return array(
	'url_base' => 'https://lks-dev.mirea.ru/xhprof/',
	'url_static' => null, // When undefined, it defaults to $config['url_base'] . 'public/'. This should be absolute URL.
	'pdo' => new PDO('mysql:dbname=sitemanager;host=localhost;charset=utf8', 'bitrix0', '6-tnqTbB-NWrpEuCX8UR'),
);
</code>

<p>Если используется mysqli, то прописываем в php.ini</p> 
<code>pdo_mysql.default_socket=/var/lib/mysqld/mysqld.sock</code>


<p>Ребутаем апача. В нужный скрипт перед шапкой:</p>

<code> tideways_xhprof_enable(TIDEWAYS_XHPROF_FLAGS_MEMORY | TIDEWAYS_XHPROF_FLAGS_CPU);
</code>

<p>и в конце (пример)</p>

<code>$xhprof_data = tideways_xhprof_disable();	
$config			= require $_SERVER["DOCUMENT_ROOT"].'/xdebug/xhprof/includes/config.inc.php';	
require_once $_SERVER["DOCUMENT_ROOT"].'/xdebug/xhprof/classes/data.php';	
$xhprof_data_obj	= new \ay\xhprof\Data($config['pdo']);
$xhprof_data_obj->save($xhprof_data);
</code>

