# phpBB RegisterLog Extension

This is the repository for the development of the phpBB RegisterLog Extension.

[![Build Status](https://travis-ci.org/borisba/registerlog.svg?branch=master)](https://travis-ci.org/borisba/registerlog)


## Before Install

**Use phpBB 3.1.4**

1. File **includes\acp\info\acp_logs.php**
  1. Find *function module() { ... }*
  2. Replace it to
	
	```ruby
 	function module()
	{
		global  $phpbb_dispatcher;
		$modes = array(
				'admin'		=> array('title' => 'ACP_ADMIN_LOGS', 'auth' => 'acl_a_viewlogs', 'cat' => array('ACP_FORUM_LOGS')),
				'mod'		=> array('title' => 'ACP_MOD_LOGS', 'auth' => 'acl_a_viewlogs', 'cat' => array('ACP_FORUM_LOGS')),
				'users'		=> array('title' => 'ACP_USERS_LOGS', 'auth' => 'acl_a_viewlogs', 'cat' => array('ACP_FORUM_LOGS')),
				'critical'	=> array('title' => 'ACP_CRITICAL_LOGS', 'auth' => 'acl_a_viewlogs', 'cat' => array('ACP_FORUM_LOGS')),
				);
		
		/**
		* Add a new log mode / modify $modes
		*
		* @event core.acp_log_add_new_mode
		* @var	array	modes		Array with modes
		*
		*/
		$vars = array('modes');
		extract($phpbb_dispatcher->trigger_event('core.acp_log_add_new_mode', compact($vars)));
		
		return array(
			'filename'	=> 'acp_logs',
			'title'		=> 'ACP_LOGGING',
			'version'	=> '1.0.0',
			'modes'		=> $modes,
		);
	}
	```

2. File **phpbb\captcha\plugins\qa.php** replace to **qa_replace/qa.php**
  1. Don't copy *qa-replace* directory to */ext/borisba/registerlog* !

## Quick Install
You can install this on the latest copy of the develop branch ([phpBB 3.1.1](https://github.com/phpbb/phpbb3)) by following the steps below:

1. [Download the latest release](https://github.com/BorisBerdichevski/RegisterLog).
2. Unzip the downloaded release, and change the name of the folder to `registerlog`.
3. In the `ext` directory of your phpBB board, create a new directory named `borisba` (if it does not already exist).
4. Copy the `registerlog` folder to `phpBB/ext/borisba/` (if done correctly, you'll have the main extension class at (your forum root)/ext/borisba/registerlog/ext.php).
5. Navigate in the ACP to `Customise -> Manage extensions`.
6. Look for `Register Log` under the Disabled Extensions list, and click its `Enable` link.

## Uninstall

1. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
2. Look for `New Topic` under the Enabled Extensions list, and click its `Disable` link.
3. To permanently uninstall, click `Delete Data` and then delete the `/ext/borisba/registerlog` folder.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)
