<?php

//SITE_ROOT
$path = $_SERVER['DOCUMENT_ROOT'] . '/repair_on_time/';
define('SITE_ROOT', $path);

//SITE_PATH
define('SITE_PATH', 'http://'.$_SERVER['HTTP_HOST'] . '/repair_on_time/');

//PRODUCTION
define('PRODUCTION', true);

//URL AMIGABLES
define('URL_AMIGABLES', TRUE);

//CSS
define('CSS_PATH', SITE_PATH . 'view/css/');

//JS
define('JS_PATH', SITE_PATH . 'view/js/');

//PLUGINS ///AÑADIDO
define('PLUGINS_PATH', SITE_PATH . 'view/plugins/');

//IMG ///contiene favicon
define('IMG_PATH', SITE_PATH . 'view/img/');

//VIDEO
define('VIDEO_PATH',SITE_PATH . 'view/video/');

//LOG
define('LOG_DIR', SITE_ROOT.'classes/log/log.class.singleton.php');
define('USER_LOG_DIR', SITE_ROOT . 'log/user/Site_User_errors.log');
define('GENERAL_LOG_DIR', SITE_ROOT . 'log/general/Site_General_errors.log');

//MODEL
define('MODEL_PATH',SITE_ROOT.'model/');
//VIEW
define('VIEW_PATH_INC',SITE_ROOT.'view/inc/');
define('VIEW_PATH_INC_ERROR',SITE_ROOT.'view/inc/templates_error/');
//IMG LOGO ////AÑADIDO
define('IMG_LOGO',SITE_ROOT.'view/img/logo_rot.png');

//LIBS
define('LIBS',SITE_ROOT . 'libs/');

//MODULES
define('MODULES_PATH',SITE_ROOT.'modules/');

//RESOURCES
define('RESOURCES',SITE_ROOT.'resources/');
//MEDIA
define('MEDIA_PATH',SITE_ROOT.'media/');
//UTILS
define('UTILS',SITE_ROOT.'utils/');

//MODULE USERS
define('FUNCTIONS_USERS', SITE_ROOT.'modules/users/utils/');
define('MODEL_PATH_USERS',SITE_ROOT.'modules/users/model/');
define('MODEL_USERS',SITE_ROOT.'modules/users/model/model/');
define('USERS_JS_PATH', SITE_PATH.'modules/users/view/js/');
define('USERS_CSS_PATH',SITE_PATH.'modules/users/view/css/');
define('USERS_VIEW_PATH', SITE_PATH.'modules/users/view/');

//MODULE PRODUCTS
define('UTILS_PRODUCTS',SITE_ROOT.'modules/products/utils/');
define('PRODUCTS_JS_LIB_PATH', SITE_PATH . 'modules/products/view/lib/');
define('PRODUCTS_JS_PATH', SITE_PATH . 'modules/products/view/js/');
define('PRODUCTS_CSS_PATH', SITE_PATH . 'modules/products/view/css/');
define('MODEL_PATH_PRODUCTS',SITE_ROOT.'modules/products/model/');
define('MODEL_PRODUCTS',SITE_ROOT.'modules/products/model/model/');

//MODULE CONTACT
define('CONTACT_JS_PATH', SITE_PATH . 'modules/contact/view/js/');
define('CONTACT_CSS_PATH', SITE_PATH . 'modules/contact/view/css/');
define('CONTACT_LIB_PATH', SITE_PATH . 'modules/contact/view/lib/');
define('CONTACT_IMG_PATH', SITE_PATH . 'modules/contact/view/img/');
define('CONTACT_VIEW_PATH', 'modules/contact/view/');

//MODULE TECHNICIANS
define('TECHNICIANS_JS_PATH',SITE_PATH. 'modules/technicians/view/js/');
define('TECHNICIANS_CSS_PATH', SITE_PATH . 'modules/technicians/view/css/');
define('MODEL_TECHNICIANS', SITE_ROOT . 'modules/technicians/model/model/');
