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
<br/>
mv 30-pdo_mysql.ini.disabled 30-pdo_mysql.ini
</code>
<br/>
<p>Отладка с помощью GET параметра</p>
<code>ay[debug]=1</code>
<br/>
<p>Ставим аналитику отсюда в подпапку сайта</p>
<code>https://github.com/itsfera/xhprof.io.git</code>
<br/>
<p>Накатываем sql из папки, правим config.inc.php, прописываем параметры. </p>
<code>
	<?php<br/>
return array(<br/>
	'url_base' => 'https://lks-dev.mirea.ru/xhprof/',<br/>
	'url_static' => null, // When undefined, it defaults to $config['url_base'] . 'public/'. This should be absolute URL.<br/>
	'pdo' => new PDO('mysql:dbname=sitemanager;host=localhost;charset=utf8', 'bitrix0', '6-tnqTbB-NWrpEuCX8UR'),<br/>
);
</code>
<br/>
<p>Если используется mysqli, то прописываем в php.ini</p> 
<code>pdo_mysql.default_socket=/var/lib/mysqld/mysqld.sock</code>

<br/>
<p>Ребутаем апача. В нужный скрипт перед шапкой:</p>

<code> tideways_xhprof_enable(TIDEWAYS_XHPROF_FLAGS_MEMORY | TIDEWAYS_XHPROF_FLAGS_CPU);
</code>
<br/>
<p>и в конце (пример)</p>

<code>$xhprof_data = tideways_xhprof_disable();	<br/>
$config			= require $_SERVER["DOCUMENT_ROOT"].'/xdebug/xhprof/includes/config.inc.php';	<br/>
require_once $_SERVER["DOCUMENT_ROOT"].'/xdebug/xhprof/classes/data.php';<br/>	
$xhprof_data_obj	= new \ay\xhprof\Data($config['pdo']);<br/>
$xhprof_data_obj->save($xhprof_data);<br/>
</code>

