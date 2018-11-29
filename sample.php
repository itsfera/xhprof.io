<?tideways_xhprof_enable(TIDEWAYS_XHPROF_FLAGS_MEMORY | TIDEWAYS_XHPROF_FLAGS_CPU);

//script here


$xhprof_data = tideways_xhprof_disable();	
$config			= require $_SERVER["DOCUMENT_ROOT"].'/xdebug/xhprof/includes/config.inc.php';	
require_once $_SERVER["DOCUMENT_ROOT"].'/xdebug/xhprof/classes/data.php';	
$xhprof_data_obj	= new \ay\xhprof\Data($config['pdo']);
$xhprof_data_obj->save($xhprof_data);
?>