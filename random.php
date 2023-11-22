<?php
require_once __DIR__ . '/default/default.php';
use azlink\workspace\config as config;
use azlink\workspace\classes\common\GenerateRandomString;

$a = [
  GenerateRandomString::generate(32),
  GenerateRandomString::generate(32),
  GenerateRandomString::generate(32)
];
echo implode('<br>', $a);