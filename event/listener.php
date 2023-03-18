<?php
/**
*
* @package registerlog
* @copyright (c) 2014 Borisba
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace borisba\registerlog\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

define('LOG_REGISTER', 6);

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\extension\manager */
	protected $phpbb_extension_manager;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\content_visibility */
	protected $phpbb_content_visibility;

	/** @var \phpbb\cache\service */
	protected $cache;

	/** @var \phpbb\plupload\plupload */
	protected $plupload;

	/** @var \phpbb\mimetype\guesser */
	protected $mimetype_guesser;

	/** @var string */
	protected $phpbb_root_path;
	protected $php_ext;

	/*function put_log($line)
	{
		//printf("put_log\n");
		//$root_path = 'c:/Inetpub/phpBB3.asc/';
      $log_file = $this->phpbb_root_path . 'cache/debug_register_logs.log';

      $ff = @fopen($log_file, 'ab+');
      if ($ff !== false)
      {
         @fwrite($ff, $line . "\n");
      }
      @fclose($ff);

	}*/



	/**
	* Constructor
	* 
	* @param \phpbb\auth\auth $auth
	* @param \phpbb\config\config $config
	* @param \phpbb\template\template $template
	* @param \phpbb\user $user
	* @param \phpbb\db\driver\driver $db
	* @param \phpbb\extension\manager $phpbb_extension_manager
	* @param \phpbb\request\request $request
	* @param \phpbb\content_visibility $phpbb_content_visibility
	* @param \phpbb\cache\service $cache
	* @param \phpbb\plupload\plupload $plupload
	* @param \phpbb\mimetype\guesser $mimetype_guesser
	* @param string $phpbb_root_path Root path
	* @param string $phpbb_ext
	*/
	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\extension\manager $phpbb_extension_manager, \phpbb\request\request $request, \phpbb\content_visibility $phpbb_content_visibility, \phpbb\cache\service $cache, \phpbb\plupload\plupload $plupload, \phpbb\mimetype\guesser $mimetype_guesser, $phpbb_root_path, $php_ext)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
		$this->db = $db;
		$this->phpbb_extension_manager = $phpbb_extension_manager;
		$this->request = $request;
		$this->phpbb_content_visibility = $phpbb_content_visibility;
		$this->cache = $cache;
		$this->plupload = $plupload;
		$this->mimetype_guesser = $mimetype_guesser;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->files_uploaded = false;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'					=>	'load_language_on_setup', // needed for define LOG_REGISTER
			'core.acp_logs_info_modify_modes'	=>	'add_register_log_info', // @since 3.2.1-RC1
			// 'core.ucp_register_requests_after' => '' // @since 3.1.11-RC1
			// 'core.ucp_register_agreement_modify_template_data' // @since 3.2.2-RC1
			'core.ucp_register_data_before'		=>	'try_register_log', // @since 3.1.4-RC1 // Попытка регистрации пользователя
			// 'core.ucp_register_data_after'
			'core.ucp_register_modify_template_data' => 'ucp_register_modify_template_data', // Запротоколировать ошибки регистрации
			'core.ucp_register_register_after'	 => 'ucp_register_register_after', // Пользователь успешно зарегистрирован

			'core.add_log'						=>	'add_type_register_log',
			'core.delete_log'					=>	'delete_type_register_log',
			'core.get_logs_modify_type'			=>	'get_logs_register_log',

			'core.plugins_qa_validate'			=>	'qa_validate',
			'core.plugins_qa_answer'			=>  'qa_answer',
		);
	}
	/**
	* Load common files during user setup
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function load_language_on_setup($event) {}

	/**
	* Event to add or modify ACP log modulemodes
	*
	* @event core.acp_logs_info_modify_modes
	* @var	array	modes	Array with modes info
	* @since 3.1.11-RC1
	* @since 3.2.1-RC1
	*/
	public function add_register_log_info($event)
	{
		$modes = $event['modes'];
		$modes = array_merge($modes, array(
			'register'	=> array('title' => 'ACP_REGISTER_LOGS', 'auth' => 'acl_a_viewlogs', 'cat' => array('ACP_FORUM_LOGS')),
		));
		$event['modes'] = $modes;
	}

	/**
	* Modify template data on the registration page
	*
	* @event core.ucp_register_modify_template_data
	* @var	array	template_vars		Array with template data
	* @var	array	data				Array with user data, read only
	* @var	array	error				Array with errors
	* @var	array	s_hidden_fields		Array with hidden field elements
	* @var	string	tpl_name			Template name
	* @since 3.2.2-RC1
	*/
	public function ucp_register_modify_template_data($event) // Ошибки при регистрации пользователя
	{
		global $phpbb_log; // TODO: Constructor
		$error = $event['error'];
		if ($this->config['enable_register_log'] && sizeof($error)) { // && submit
			$user_id = (empty($this->user->data)) ? ANONYMOUS : $this->user->data['user_id'];
			$user_ip = (empty($this->user->ip)) ? '' : $this->user->ip;
			$phpbb_log->add('register', $user_id, $user_ip, 'REGISTER_ERROR', time(), array(
				$event['data']['username'], $event['data']['email'], 0, $this->config['max_reg_attempts'],
				time() - abs($this->request->variable('creation_time', 0)),
				implode('<li>', $error), $this->user->data['session_id'],
			));
		}
	}

	/**
	* Perform additional actions after user registration
	*
	* @event core.ucp_register_register_after
	* @var	array		user_row	Array with user registration data
	* @var	array		cp_data		Array with custom profile fields data
	* @var	array		data		Array with current ucp registration data
	* @var	string		message		Message to be displayed to the user after registration
	* @var	string		server_url	Server URL
	* @var	int			user_id		New user ID
	* @var	string		user_actkey	User activation key
	* @since 3.2.4-RC1
	*/
	public function ucp_register_register_after($event) // Пользователь успешно зарегистрирован
	{
		global $phpbb_log; // TODO: Constructor
		if ($this->config['enable_register_log']) {

			// COPPA Ignored
			if ($this->config['require_activation'] == USER_ACTIVATION_SELF && $this->config['email_enable'])
				$log_operation = 'REGISTER_SUCSESS_INACTIVE';
			else if ($this->config['require_activation'] == USER_ACTIVATION_ADMIN && $this->config['email_enable'])
				$log_operation = 'REGISTER_SUCSESS_INACTIVE_ADMIN';
			else $log_operation = 'REGISTER_SUCSESS';

			$user_ip = (empty($this->user->ip)) ? '' : $this->user->ip;
			$phpbb_log->add('register', $event['user_id'], $user_ip, $log_operation, time(), array(
				0, $this->config['max_reg_attempts'],
				time() - abs($this->request->variable('creation_time', 0)),
				$this->user->data['session_id'],
			));
		}
	}

	/**
	* Add UCP register data before they are assigned to the template or submitted
	*
	* To assign data to the template, use $template->assign_vars()
	*
	* @event core.ucp_register_data_before
	* @var	bool	submit		Do we display the form only
	*							or did the user press submit
	* @var	array	data		Array with current ucp registration data
	* @since 3.1.4-RC1
	*/
	public function try_register_log($event)
	{
		$submit = $event['submit'];
		if ($submit)
		{
			if ($this->config['enable_register_log'])
			{
				$username = $this->request->variable('username', '', true);
				add_log('register', 'REGISTER_TRACE', $username);
			}
		}
	}

	/*
		* @event core.add_log
		* @var	string	mode			Mode of the entry we log
		* @var	int		user_id			ID of the user who triggered the log
		* @var	string	log_ip			IP of the user who triggered the log
		* @var	string	log_operation	Language key of the log operation
		* @var	int		log_time		Timestamp, when the log was added
		* @var	array	additional_data	Array with additional log data
		* @var	array	sql_ary			Array with log data we insert into the
		*							database. If sql_ary[log_type] is not set,
		*							we won't add the entry to the database.
	*/

	public function add_type_register_log($event)
	{
		$mode = $event['mode'];
		$sql_ary = $event['sql_ary'];
		$additional_data = $event['additional_data'];
		switch ($mode)
		{
			case 'register':

				$sql_ary += array(
					'log_type'		=> LOG_REGISTER,
					'log_data'		=> (!empty($additional_data)) ? serialize($additional_data) : '',
				);
				$event['sql_ary'] = $sql_ary;
			break;
		}
	}

	/**
	* Allows to modify log data before we delete it from the database
	*
	* NOTE: if sql_ary does not contain a log_type value, the entry will
	* not be deleted in the database. So ensure to set it, if needed.
	*
	* @event core.delete_log
	* @var	string	mode			Mode of the entry we log
	* @var	string	log_type		Type ID of the log (should be different than false)
	* @var	array	conditions		An array of conditions, 3 different  forms are accepted
	* 								1) <key> => <value> transformed into 'AND <key> = <value>' (value should be an integer)
	*								2) <key> => array(<operator>, <value>) transformed into 'AND <key> <operator> <value>' (values can't be an array)
	*								3) <key> => array('IN' => array(<values>)) transformed into 'AND <key> IN <values>'
	*								A special field, keywords, can also be defined. In this case only the log entries that have the keywords in log_operation or log_data will be deleted.
	* @since 3.1.0-b4
	*/

	public function delete_type_register_log($event)
	{
		$mode = $event['mode'];
		$log_type = $event['log_type'];
		if ($mode == 'register')
		{
			$log_type = LOG_REGISTER;
			$event['log_type'] = $log_type;
		}
	}

	/**
	* Overwrite log type and limitations before we count and get the logs
	*
	* NOTE: if log_type is false, no entries will be returned.
	*
	* @event core.get_logs_modify_type
	* @var	string	mode		Mode of the entries we display
	* @var	bool	count_logs	Do we count all matching entries?
	* @var	int		limit		Limit the number of entries
	* @var	int		offset		Offset when fetching the entries
	* @var	mixed	forum_id	Limit entries to the forum_id,
	*							can also be an array of forum_ids
	* @var	int		topic_id	Limit entries to the topic_id
	* @var	int		user_id		Limit entries to the user_id
	* @var	int		log_time	Limit maximum age of log entries
	* @var	string	sort_by		SQL order option
	* @var	string	keywords	Will only return entries that have the
	*							keywords in log_operation or log_data
	* @var	string	profile_url	URL to the users profile
	* @var	int		log_type	Limit logs to a certain type. If log_type
	*							is false, no entries will be returned.
	* @var	string	sql_additional	Additional conditions for the entries,
	*								e.g.: 'AND l.forum_id = 1'
	* @since 3.1.0-a1
	*/

	public function get_logs_register_log($event)
	{
		$mode = $event['mode'];
		$log_type = $event['log_type'];

		if ($mode == 'register')
		{
			$log_type = LOG_REGISTER;
			$event['log_type'] = $log_type;
		}
	}

	/*
	*/

	public function qa_validate($event)
	{
		global $db, $user;
		$trap = $event['trap'];
		$trap =  true;
		$event['trap'] = $trap;

		$qa = $event['qa'];
		$error = $event['error'];
		$ret_val = $event['return_val'];

		if (!sizeof($qa->question_ids))
		{
			$error = $user->lang['CONFIRM_QUESTION_WRONG'];
// Register LOG  Start -->
			if ($this->config['enable_register_log'])
			{
				add_log('register', 'REGISTER_WITHOUT_CONFIRM', 'validate');
			}
//-->Register LOG  End
			$event['error'] = $error;
			return;
		}

		if (!$qa->confirm_id)
		{
			$error = $user->lang['CONFIRM_QUESTION_WRONG'];
		}
		else
		{
			if( $this->config['enable_russian_only'] && $user->lang_name == 'en')
			{
	// Register LOG  Start -->
				if ($this->config['enable_register_log'])
				{
					add_log('register', 'REGISTER_ENGLISH');
				}
	//-->Register LOG  End
				$qa->solved = false;
				$error = $user->lang['CONFIRM_QUESTION_ENGLISH'];
			}
			else
			{
				if ($qa->check_answer())
				{
					// $this->delete_code(); commented out to allow posting.php to repeat the question
					$qa->solved = true;
				}
				else
				{
					$error = $user->lang['CONFIRM_QUESTION_WRONG'];
				}
			}
		}

		if (strlen($error))
		{
			// okay, incorrect answer. Let's ask a new question.
			$qa->new_attempt();
			$qa->solved = false;

			$event['error'] = $error;
			return;
		}
		else
		{
			$ret_val = false;
			$event['return_val'] = $ret_val;
			return;
		}

	}

	/*
	*/

	public function qa_answer($event)
	{
		$qa = $event['qa'];
		$answer = $event['answer'];

// Register LOG  Start -->
		if ($this->config['enable_register_log'])
		{
			add_log('register', 'REGISTER_TEXT_CONFIRM', $qa->question_text, $answer);
		}
//-->Register LOG  End
	}

}
