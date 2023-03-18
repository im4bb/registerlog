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
	'ACP_REGISTERLOG'			=> 'Логи регистрации', // Заголовок на странице настройки расширения
	'ACP_BOARD_REGISTERLOG'		=> 'Логи регистрации', // Раздел в левом меню настройки расширений
	'ACP_REGISTERLOG_EXPLAIN'	=> 'Ведение логов регистрации', // Пункт в левом меню настройки расширений

	'ACL_A_REGISTERLOG'			=> 'Может изменять настройки',

	'ACP_REGISTER_LOGS'			=> 'Лог регистраций', // Пункт меню и заголовок
	'ACP_REGISTER_LOGS_EXPLAIN'	=> 'Это список всех попыток регистраций пользователей',
	'LOG_CLEAR_REGISTER'		=> '<strong>Очищен лог регистраций</strong>',

	// 'REGISTER_TRACE'			=> 'Попытка регистрации пользователя <b>%1s</b>.',
	// 'REGISTER_SUCSESS'		=> 'Пользователь <b>%1s</b> был успешно зарегистрирован.',
	// 'REGISTER_TEXT_CONFIRM'		=> 'На вопрос <b>%1s</b> пользователь ответил <b>%1s</b>.',
	'REGISTER_ENGLISH'		=> 'С British English мы не регистрируем!',
	// 'REGISTER_ERROR'		=> 'Пользователь <b>%1s</b> не зарегистрирован: %1s.', // не используется!
	'REGISTER_WITHOUT_CONFIRM'	=> '%ls: попытка обхода ответа на вопрос текстового подтверждения!',

	// Расшифровка сообщений в логах
	// 'REGISTER_TRACE'		=> 'Попытка регистрации пользователя «<b>%s</b>»', // TODEL
	'REGISTER_SUCSESS'		=> 'Пользователь <b>%s</b> успешно зарегистрирован с %1$d-ой попытки из %2$d через %3$ds после генерации формы<br />» %4$s',
	'REGISTER_SUCSESS_INACTIVE' => 'Пользователь успешно зарегистрирован с %1$d-ой попытки из %2$d через %3$ds после генерации формы, требуется самостоятельная активация<br />» %4$s',
	'REGISTER_SUCSESS_INACTIVE_ADMIN' => 'Пользователь <b>%s</b> успешно зарегистрирован с %1$d-ой попытки из %2$d через %3$ds после генерации формы, требуется активация администратором<br />» %4$s',
	'REGISTER_TEXT_CONFIRM'	=> 'На вопрос «%1$s» пользователь ответил «%2$s»', // TODEL
	'REGISTER_TEXT_CONFIRM_SOLVED' => 'На вопрос «%1$s?» пользователь <strong>верно</strong> ответил «%2$s» (попытка %3$d/%4$d)<br />» %5$s',
	'REGISTER_TEXT_CONFIRM_NOT_SOLVED' => 'На вопрос «%1$s?» пользователь <strong>неверно</strong> ответил «%2$s» (попытка %3$d/%4$d)<br />» %5$s',
	'REGISTER_ERROR'		=> 'Ошибки при регистрации пользователя «%1$s» (%2$s), попытка %3$d/%4$d через %5$ds после генерации формы: <ul><li>%6$s</ul> » %7$s',

	'REGISTER_LOG_ENABLE'	=>  'Включить ведение логов регистрации',

	'REGISTER_RUSSIAN_ONLY'	=>  'Запретить регистрацию без перехода на русский язык',
	'REGISTER_RUSSIAN_ONLY_EXPLAIN'	=>  'Установите язык конференции по умолчанию British English, введите хотя бы один вопрос для этого языка. Боты не сумеют перевести панель на русский язык',
));
