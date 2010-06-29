<?php
/**
 * usersync.php
 *@package Listbingo
 *@subpackage usersync
 *
 *Listbingo User-Sync plugin
 *code Bruce
 *
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();


jimport('joomla.event.plugin');

class plgUserUsersync extends JPlugin
{
	function plgUserUsersync(& $subject)
	{
		parent::__construct($subject);
	}

	/**
	 * This method will set country id and region id as preferences in profile table. 
	 *
	 * @access	public
	 * @param   array   holds the user data
	 * @param 	array   array holding options (remember, autoregister, group)
	 * @return	object	A JUser object
	 * @since	1.5
	 */

	function onLoginUser($user, $options = array())
	{
		global $mainframe;

		//set default option value
		$option = 'com_listbingo';

		//Get Application
		$app =& JFactory::getApplication();

		//check if the user is admin or not
		if(!$app->isAdmin())
		{

			// get Plugin Parameters
			$plugin =& JPluginHelper::getPlugin('user', 'usersync');
			$params = new JParameter( $plugin->params );

			if(!$params->get('enable_current_location'))
			{
				//importing joomla user helper
				jimport('joomla.user.helper');

				$instance =& $this->_getUser($user, $options);
				$userid = $instance->get('id');

				$db = JFactory::getDBO();
				$query = "SELECT preferences FROM #__gbl_profile WHERE user_id=$userid";
				$db->setQuery($query);
				$result = $db->loadObject();

				//check if result count is greater than 0
				if(count($result)>0)
				{

					$preferences=new JParameter($result->preferences);

					if(count($result)>0)
					{
						if($preferences->get('country'))
						{
							$mainframe->setUserState($option.'country',$preferences->get('country'));
						}
						if($preferences->get('region'))
						{
							$mainframe->setUserState($option.'region',$preferences->get('region'));
						}
					}
					$mainframe->enqueueMessage("Your region has been changed to last saved region in your profile");
				}
			}
			else
			{
				//do nothing
			}
			return true;
		}

	}


	/**
	 * This method will return a user object
	 *
	 * If options['autoregister'] is true, if the user doesn't exist yet he will be created
	 *
	 * @access	public
	 * @param   array   holds the user data
	 * @param 	array   array holding options (remember, autoregister, group)
	 * @return	object	A JUser object
	 * @since	1.5
	 */
	function &_getUser($user, $options = array())
	{
		$instance = new JUser();
		if($id = intval(JUserHelper::getUserId($user['username'])))  {
			$instance->load($id);
			return $instance;
		}

		//TODO : move this out of the plugin
		jimport('joomla.application.component.helper');
		$config   = &JComponentHelper::getParams( 'com_users' );
		$usertype = $config->get( 'new_usertype', 'Registered' );

		$acl =& JFactory::getACL();

		$instance->set( 'id'			, 0 );
		$instance->set( 'name'			, $user['fullname'] );
		$instance->set( 'username'		, $user['username'] );
		$instance->set( 'password_clear'	, $user['password_clear'] );
		$instance->set( 'email'			, $user['email'] );	// Result should contain an email (check)
		$instance->set( 'gid'			, $acl->get_group_id( '', $usertype));
		$instance->set( 'usertype'		, $usertype );

		//If autoregister is set let's register the user
		$autoregister = isset($options['autoregister']) ? $options['autoregister'] :  $this->params->get('autoregister', 1);

		if($autoregister)
		{
			if(!$instance->save()) {
				return JError::raiseWarning('SOME_ERROR_CODE', $instance->getError());
			}
		} else {
			// No existing user and autoregister off, this is a temporary user.
			$instance->set( 'tmp_user', true );
		}

		return $instance;
	}
}
?>
