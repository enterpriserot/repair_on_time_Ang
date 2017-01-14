<?php
//PROJECT
define('PROJECT', '/repair_on_time_Ang/backend');

//SITE_ROOT
define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'] . PROJECT);

//SITE_PATH
define('SITE_PATH', '//'.$_SERVER['HTTP_HOST'] . PROJECT);

//LOG
define('GENERAL_LOG_DIR', SITE_ROOT . '/log/general/Site_General_errors.log');

//PRODUCTION
define('PRODUCTION', true);

//MODEL
define('MODEL_PATH', SITE_ROOT . '/model/');

//MODULES
define('MODULES_PATH', SITE_ROOT . '/modules/');

//RESOURCES
define('RESOURCES', SITE_ROOT . '/resources/');

//MEDIA
define('MEDIA_ROOT', SITE_ROOT . '/media/');
define('MEDIA_PATH', SITE_PATH . '/media/');

//UTILS
define('UTILS', SITE_ROOT . '/utils/');

//URL AMIGABLES
define('URL_AMIGABLES', TRUE);

//LIBS
define('LIBS', SITE_ROOT . '/libs/');

//CLASSES
define('CLASSES', SITE_ROOT . '/classes/');

// //MODEL USERS
define('UTILS_USERS', SITE_ROOT . '/modules/users/utils/');
define('MODEL_USERS', SITE_ROOT . '/modules/users/model/model/');
//
// //MODEL TECHNICIANS
define('MODEL_TECHNICIANS', SITE_ROOT . '/modules/technicians/model/model/');

define('IMG_LOGO',MEDIA_ROOT.'logo_rot.png');
