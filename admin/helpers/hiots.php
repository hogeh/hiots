<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hispindels
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Hispindels helper.
 *
 * @since  1.6
 */
class HiotsHelper extends JHelperContent
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public static function addSubmenu($vName = 'hispindels')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_HIOTS_DEVICE_RECORDS'),
			'index.php?option=com_hiots&view=hdevrecs',
			$vName == 'hdevrecs'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_HIOTS_IOTS'),
			'index.php?option=com_hiots&view=hiots',
			$vName == 'hiotss'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_HIOTS_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_hiots',
			$vName == 'categories'
		);
	}

	/**
	 * Adds Count Items for HIots Category Manager.
	 *
	 * @param   stdClass[]  &$items  The hispindels category objects.
	 *
	 * @return  stdClass[]  The hispindels category objects.
	 *
	 * @since   3.6.0
	 
	public static function countItems(&$items)
	{
		$db = JFactory::getDbo();

		foreach ($items as $item)
		{
			$item->count_trashed     = 0;
			$item->count_archived    = 0;
			$item->count_unpublished = 0;
			$item->count_published   = 0;

			$query = $db->getQuery(true)
				->select('state, COUNT(*) AS count')
				->from($db->qn('#__hispindels'))
				->where($db->qn('catid') . ' = ' . (int) $item->id)
				->group('state');

			$db->setQuery($query);
			$hispindels = $db->loadObjectList();

			foreach ($hispindels as $hispindel)
			{
				if ($hispindel->state == 1)
				{
					$item->count_published = $hispindel->count;
				}
				elseif ($hispindel->state == 0)
				{
					$item->count_unpublished = $hispindel->count;
				}
				elseif ($hispindel->state == 2)
				{
					$item->count_archived = $hispindel->count;
				}
				elseif ($hispindel->state == -2)
				{
					$item->count_trashed = $hispindel->count;
				}
			}
		}

		return $items;
	}*/
}
