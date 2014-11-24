<?php
/**
*
* @package registerlog
* @copyright (c) 2014 Borisba
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace borisba\registerlog\acp;

class newtopic_info
{
	function module()
	{
		return array(
			'filename'	=> '\borisba\registerlog\acp\usernotice_module',
			'title'		=> 'ACP_NEWTOPIC',
			'version'	=> '0.0.1',
			'modes'		=> array(
				'config_registerlog'		=> array('title' => 'ACP_NTP_CONFIG', 'auth' => 'ext_borisba/registerlog && acl_a_registerlog', 'cat' => array('ACP_NTP_CONFIG')),
			),
		);
	}
}
