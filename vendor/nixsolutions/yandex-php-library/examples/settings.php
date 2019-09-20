<?php
/**
 * Load and return settings array
 *
 * @author   Anton Shevchuk
 * @created  04.10.13 12:00
 */
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

require_once dirname(__FILE__) . '/../vendor/autoload.php';

return parse_ini_file(dirname(__FILE__) .'/settings.ini', true);
