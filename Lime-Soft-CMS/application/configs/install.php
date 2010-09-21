<?php

return array_merge_recursive(array(
	'acl' => array(
		'role' => array(
			'guest' => null,
			'user' => 'guest',
			'admin' => null,
			'super' => null
		),
		'permission' => array(
			'guest' => array(
				'/' => array('read' => 'deny'),
				'/default' => array('read' => 'allow'),
				'/services/authentication' => array('read' => 'allow')
			),
			'super' => array(
				'/' => array('read' => 'allow')
			)
		)
	)
), include dirname(__FILE__) . '/' . APPLICATION_ENV . '.install.php');
