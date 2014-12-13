<?php
/**
*
* @package registerlog
* @copyright (c) 2014 Borisba
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace borisba\registerlog\migrations\v0xx;

class v_0_0_1 extends \phpbb\db\migration\migration
{
	public function CheckIfRegisterModulePresent()
	{

		$sql = 'SELECT * FROM ' . MODULES_TABLE . " WHERE module_langname='Лог регистраций'";

		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return $row;
	}

	public function effectively_installed()
	{
		return isset($this->config['registerlog_version']) && version_compare($this->config['registerlog_version'], '0.0.1', '>=');
	}

	static public function depends_on()
	{
			return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		return array(
			// Add configs
			array('config.add', array('enable_register_log', '0')),

			// Current version
			array('config.add', array('registerlog_version', '0.0.1')),

			// Add ACP modules
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_BOARD_REGISTERLOG')),
			array('module.add', array('acp', 'ACP_BOARD_REGISTERLOG', array(
					'module_basename'	=> '\borisba\registerlog\acp\registerlog_module',
					'module_langname'	=> 'ACP_REGISTERLOG_EXPLAIN',
					'module_mode'		=> 'config_registerlog',
					'module_auth'		=> 'ext_borisba/registerlog && acl_a_registerlog',
			))),

			array('if', array(
				($this->CheckIfRegisterModulePresent()),
				array('module.remove', array('acp', 'ACP_FORUM_LOGS', array(
					'module_basename'	=> 'acp_logs',
					'module_langname'	=> 'Лог регистраций',
					'module_mode'		=> 'register',
					'module_auth'		=> 'acl_a_viewlogs',
				))),
			)),

			array('module.add', array('acp', 'ACP_FORUM_LOGS', array(
					'module_basename'	=> 'acp_logs',
					'module_langname'	=> 'ACP_REGISTER_LOGS',
					'module_mode'		=> 'register',
					'module_auth'		=> 'acl_a_viewlogs',
			))),

			// Add permissions
			array('permission.add', array('a_registerlog', true)),
			array('permission.add', array('f_not_change_subject', false)),

			// Set permissions
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_registerlog')),
			array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_registerlog')),
			array('permission.permission_set', array('ROLE_FORUM_FULL', 'f_not_change_subject')),
		);
	}
}
