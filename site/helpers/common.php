<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hiots
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Hiots Component Helper.
 *
 * @since  1.5
 */
class CommonHogehsHelper{

	public static function getTimeZone() {
        $userTz = JFactory::getUser()->getParam('timezone');
        $timeZone = JFactory::getConfig()->get('offset');
        if($userTz) {
            $timeZone = $userTz;
        }
        return new DateTimeZone($timeZone);
	}

    public static function showlocaltime($timeZone,$germantime=NULL,$form='H:i',$utctime=NULL) {
		 
			if ($germantime) {
				$utctime=DateTime::createFromFormat('d.m.Y H:i:s', $germantime)->format('Y-m-d H:i:s');
			}
			if (!$utctime AND !$germantime){$utctime= JFactory::getDate()->format('d.m.Y H:i:s');}
			$date=new JDate($utctime);
			$date->setTimezone($timeZone);
			return $date->format($form,true,false);
    }
}

