<?php
const FILES = [
    __DIR__ . '/vqmod/checked.cache',
    __DIR__ . '/vqmod/mods.cache'
];

const DIRS = [
    __DIR__ . '/vqmod/vqcache/',
    __DIR__ . '/vqmod/logs/'
];

foreach (FILES as $file) {
    clear($file);
}

foreach (DIRS as $dir) {
    clearDir($dir);
}

function clear($file)
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        @unlink($file);
    } else {
        echo $file, '<br/>';
    }
}

function clearDir($dir)
{
    $files = glob($dir . '{*.log,*.php,*.tpl}', GLOB_BRACE);
    foreach ($files as $file) {
        clear($file);
    }
    $dirs = glob($dir . '*', GLOB_ONLYDIR);
    foreach ($dirs as $sub) {
        clearDir($sub . '/');
    }
}