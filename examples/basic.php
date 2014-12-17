<?php
require("../src/cache.php");

$cache = new Rodrigoalviani\Cache\Cache($_SERVER['REQUEST_URI']);
$cache->cacheInit();
?>

Hi, currently date() is <?=date("d/m/Y H:i:s")?>

<?php
$cache->cacheEnd();
?>