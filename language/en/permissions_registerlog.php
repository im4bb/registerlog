<?php
/**
*
* registerlog [English]
*
* @package registerlog
* @copyright (c) 2014 William Jacoby (bonelifer)
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
	'ACP_REGISTERLOG'			=> 'Registration logs',
	'ACP_BOARD_REGISTERLOG'		=> 'Registration logs',
	'ACP_REGISTERLOG_EXPLAIN'	=> 'Registration logs',
));
