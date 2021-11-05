<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hiots
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JHtml::_('behavior.tabstate');

if (!JFactory::getUser()->authorise('core.manage', 'com_hiots'))
{
	throw new JAccessExceptionNotallowed(JText::_('JERROR_ALERTNOAUTHOR'), 403);
}

$controller	= JControllerLegacy::getInstance('Hiots');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
