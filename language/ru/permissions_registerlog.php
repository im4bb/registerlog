<?php
/**
*
* registerlog [Russian]
*
* @package registerlog
* @copyright (c) 2014 Borisba
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_REGISTERLOG'			=> 'Логи регистрации',
	'ACP_BOARD_REGISTERLOG'		=> 'Логи регистрации',
	'ACP_REGISTERLOG_EXPLAIN'	=> 'Ведение логов регистрации',

	'ACL_A_REGISTERLOG'			=> 'Может изменять настройки',
	// 'ACL_F_NOT_CHANGE_SUBJECT'	=> 'Может изменять заголовок',
));
