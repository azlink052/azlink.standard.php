<?php
use azlink\workspace\classes\Theme;
use const azlink\workspace\config\SITE_DESCRIPTION;
require_once __DIR__ . '/default/default.php';

$theme = new Theme;
$theme->description = 'test';

var_dump($theme->description);
var_dump(SITE_DESCRIPTION);