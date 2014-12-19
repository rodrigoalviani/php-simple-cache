<?php
require("../src/cache.php");

$cache = new Rodrigoalviani\Cache\Cache($_SERVER['REQUEST_URI']);

$cache->set_filePath('tmp/');
$cache->set_cacheMaxAge(84600);
$cache->set_cacheExtension('.tmp');

$cache->cacheInit();
?>

Hi, currently date() is <?=date("d/m/Y H:i:s")?>

<?php
$cache->cacheEnd();
?>