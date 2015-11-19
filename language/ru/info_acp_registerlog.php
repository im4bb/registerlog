<?php
/**
*
* registerlog [Russian]
*
* @package language registerlog
* @copyright (c) 2013 Borisba
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
	'ACP_REGISTERLOG'			=> 'Логи регистрации',
	'ACP_BOARD_REGISTERLOG'		=> 'Логи регистрации',
	'ACP_REGISTERLOG_EXPLAIN'	=> 'Ведение логов регистрации',

	'ACP_REGISTER_LOGS_EXPLAIN'	=> 'Это список всех попыток регистраций пользователей.',
	'ACP_REGISTER_LOGS'			=> 'Лог регистраций',
	'LOG_CLEAR_REGISTER'		=> '<strong>Очищен лог регистраций</strong>',

	'REGISTER_TRACE'		=> 'Попытка регистрации пользователя <b>%1s</b>.',
	'REGISTER_SUCSESS'		=> 'Пользователь <b>%1s</b> был успешно зарегистрирован.',
	'REGISTER_TEXT_CONFIRM'		=> 'На вопрос <b>%1s</b> пользователь ответил <b>%1s</b>.',
	'REGISTER_ENGLISH'		=> 'С British English мы не регистрируем!',
	'REGISTER_ERROR'		=> 'Пользователь <b>%1s</b> не зарегистрирован: %1s.',
	'REGISTER_WITHOUT_CONFIRM'	=> '%ls: попытка обхода ответа на вопрос текстового подтверждения!',

	'REGISTER_LOG_ENABLE'	=>  'Включить ведение логов регистрации',

	'REGISTER_RUSSIAN_ONLY'	=>  'Запретить регистрацию без перехода на русский язык',
	'REGISTER_RUSSIAN_ONLY_EXPLAIN'	=>  'Установите язык конференции по умолчанию British English, введите хотя бы один вопрос для этого языка. Боты не сумеют перевести панель на русский язык',
));
