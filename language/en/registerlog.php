<?php
/**
*
* registerlog [English]
*
* @package language registerlog
* @copyright (c) 2014 William Jacoby (bonelifer)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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

	'ACP_REGISTER_LOGS_EXPLAIN'	=> 'List of all user\'s registrations',
	'ACP_REGISTER_LOGS'			=> 'Registration log',
	'LOG_CLEAR_REGISTER'	=> '<strong>Cleared Registration log</strong>',

	'REGISTER_TRACE'		=> 'Register user <b>%1s</b>.',
	'REGISTER_SUCSESS'		=> 'User <b>%1s</b> registeres sucessfully.',
	'REGISTER_TEXT_CONFIRM'		=> 'Asked <b>%1s</b> user answered <b>%1s</b>.',
	'REGISTER_ENGLISH'		=> 'No British English!',
	'REGISTER_ERROR'		=> 'User <b>%1s</b> did not registered: %1s.',
	'REGISTER_WITHOUT_CONFIRM'	=> '%ls: tryng register without answering!',

	'REGISTER_LOG_ENABLE'	=>  'Enable registration logs',

));
