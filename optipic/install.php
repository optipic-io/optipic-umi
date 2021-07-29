<?php

$iconSrc = dirname(__FILE__).'/icon/optipic.png';
$iconPath = CURRENT_WORKING_DIR .'/images/cms/admin/modern/icon/';
if (!is_dir($iconPath)){
    mkdir($iconPath, 0777, true);
}
copy($iconSrc, $iconPath.'optipic.png');

$stylesSrc = dirname(__FILE__).'/styles/';
if ($handle = opendir($stylesSrc)) {
    $stylesPath = CURRENT_WORKING_DIR .'/styles/skins/modern/data/modules/optipic/';

    if (!is_dir($stylesPath)){
        mkdir($stylesPath);
    }

    while (false !== ($entry = readdir($handle))) {
        if (is_file($stylesSrc . $entry)){
            copy($stylesSrc . $entry, $stylesPath . $entry);
        }
    }

    closedir($handle);
}

/**
 * @var array $INFO реестр модуля
 */

$INFO = [
    'name' => 'optipic', // Имя модуля
    'config' => '1', // У модуля есть настройки
//    'default_method' => 'page', // Метод по умолчанию в клиентской части
    'default_method_admin' => 'config', // Метод по умолчанию в административной части
];

/**
 * @var array $COMPONENTS файлы модуля
 */

$COMPONENTS = [
    './classes/components/optipic/install.php',
    './classes/components/optipic/class.php',
    './classes/components/optipic/ImgUrlConverter.php',
    './classes/components/optipic/admin.php',
    './classes/components/optipic/customAdmin.php',
    './classes/components/optipic/macros.php',
    './classes/components/optipic/customMacros.php',
    './classes/components/optipic/i18n.php',
    './classes/components/optipic/i18n.en.php',
    './classes/components/optipic/lang.php',
    './classes/components/optipic/lang.en.php',
    './classes/components/optipic/permissions.php',
    './classes/components/optipic/events.php',
    './classes/components/optipic/handlers.php'
];