# xhprof.io GUI

<h1>Профилирование через xhprof</h1>
<Br/><Br/>
<div>Ставим приблуду https://tideways.com/profiler/xhprof-for-php7</div> 
<div>
{{{$ yum install gcc
$ yum install php-devel
$ git clone https://github.com/tideways/php-profiler-extension.git
$ cd php-profiler-extension
$ phpize
$ ./configure
$ make
$ sudo make install
}}}
</div>

<div>Модуль подключаем в php.d</div>

{{{extension=tideways_xhprof.so
}}}

<div>Не забываем включить модули PDO и PDO MySQL</div>
{{{mv 20-pdo.ini.disabled 20-pdo.ini
mv 30-pdo_mysql.ini.disabled 30-pdo_mysql.ini
}}}

<div>Отладка с помощью GET параметра</div>
{{{ay[debug]=1}}}

<div>Ставим аналитику отсюда в подпапку сайта</div>

{{{https://github.com/itsfera/xhprof.io.git}}}

<div>Накатываем sql из папки, правим config.inc.php, прописываем параметры. </div>
{{{<?php
return array(
	'url_base' => 'https://lks-dev.mirea.ru/xhprof/',
	'url_static' => null, // When undefined, it defaults to $config['url_base'] . 'public/'. This should be absolute URL.
	'pdo' => new PDO('mysql:dbname=sitemanager;host=localhost;charset=utf8', 'bitrix0', '6-tnqTbB-NWrpEuCX8UR'),
);}}}

<div>Если используется mysqli, то прописываем в php.ini</div> 
{{{pdo_mysql.default_socket=/var/lib/mysqld/mysqld.sock}}}


<div>Ребутаем апача. В нужный скрипт перед шапкой:</div>

{{{ tideways_xhprof_enable(TIDEWAYS_XHPROF_FLAGS_MEMORY | TIDEWAYS_XHPROF_FLAGS_CPU);
}}}

<div>и в конце (пример)</div>

{{{$xhprof_data = tideways_xhprof_disable();	
$config			= require $_SERVER["DOCUMENT_ROOT"].'/xdebug/xhprof/includes/config.inc.php';	
require_once $_SERVER["DOCUMENT_ROOT"].'/xdebug/xhprof/classes/data.php';	
$xhprof_data_obj	= new \ay\xhprof\Data($config['pdo']);
$xhprof_data_obj->save($xhprof_data);
}}}

[[Категория:Backend]]



