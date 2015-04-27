<?php
if (!defined('IN_ECS')) {
    die('Hacking attempt');
}
echo __FILE__.'<br/>';
echo chdir(dirname(__FILE__)).'<br/>';
echo str_replace('includes/init.php', '', str_replace('\\', '/', __FILE__));

define('root',dirname(__FILE__));
define('ctx',dirname($_SERVER[SCRIPT_NAME]));
