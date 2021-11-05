<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hiots
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('HiotsHelper', JPATH_ADMINISTRATOR . '/components/com_hiots/helpers/hiots.php');
JLoader::register('HiotsHelperRoute', JPATH_SITE . '/components/com_hiots/helpers/route.php');
JLoader::register('CategoryHelperAssociation', JPATH_ADMINISTRATOR . '/components/com_categories/helpers/association.php');

/**
 * Hiots Component Association Helper
 *
 * @since  3.0
 */
abstract class HiotsHelperAssociation extends CategoryHelperAssociation
{
	/**
	 * Method to get the associations for a given item
	 *
	 * @param   integer  $id    Id of the item
	 * @param   string   $view  Name of the view
	 *
	 * @return  array   Array of associations for the item
	 *
	 * @since   3.0
	 */
	public static function getAssociations($id = 0, $view = null)
	{
		$jinput = JFactory::getApplication()->input;
		$view   = is_null($view) ? $jinput->get('view') : $view;
		$id     = empty($id) ? $jinput->getInt('id') : $id;

		if ($view == 'category' || $view == 'categories')
		{
			return self::getCategoryAssociations($id, 'com_hiots');
		}

		return array();
	}
}
