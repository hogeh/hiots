<?php
/**
 * @copyright	Copyright (C) 2016 Horst Gehrmann. All rights reserved.
 * @copyright	Copyright (C) 2005 - 2016 Open Source Matters,  Inc. All right reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
		
class HiotsControllerHiots extends JControllerAdmin
{
	public function getModel($name = 'hiots', $prefix = '', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}	
