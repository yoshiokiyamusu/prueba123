<?php

// Keep database credentials in a separate file
// 1. Easy to exclude this file from source code managers
// 2. Unique credentials on development and production servers
// 3. Unique credentials if working with multiple developers
//GRANT ALL PRIVILEGES ON `cocotfyma`.* TO 'webuser'@'localhost' WITH GRANT OPTION;

//siteground

define("DB_SERVER", "sgp42.siteground.asia");//host
define("DB_USER", "cocotfym_user");
define("DB_PASS", "Stalucia3");
define("DB_NAME", "cocotfym_db");

/*
define("DB_SERVER", "sql211.epizy.com");//host
define("DB_USER", "epiz_22733792");
define("DB_PASS", "682d745p");
define("DB_NAME", "epiz_22733792_practice");
*/
/*
//para conectarse al localhost de la laptop
define("DB_SERVER", "localhost");//host
define("DB_USER", "webuser");
define("DB_PASS", "yoshio12qw");
define("DB_NAME", "corner_tool");
*/
?>
