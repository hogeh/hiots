<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hiots
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Hiot Component HTML Helper.
 *
 * @since  1.5
 */
class JHtmlIcon
{
	/**
	 * Create a link to create a new hiot
	 *
	 * @param   mixed  $hiot  Unused
	 * @param   mixed  $params   Unused
	 *
	 * @return  string
	 */
	public static function create($hiot, $params)
	{
		JHtml::_('bootstrap.tooltip');

		$uri = JUri::getInstance();
		$url = JRoute::_(HiotsHelperRoute::getFormRoute(0, base64_encode($uri)));
		$text = JHtml::_('image', 'system/new.png', JText::_('JNEW'), null, true);
		$button = JHtml::_('link', $url, $text);

		return '<span class="hasTooltip" title="' . JHtml::tooltipText('COM_HIOTS_FORM_CREATE_HIOT') . '">' . $button . '</span>';
	}

	/**
	 * Create a link to edit an existing hiot
	 *
	 * @param   object                     $hiot  Hiot data
	 * @param   \Joomla\Registry\Registry  $params   Item params
	 * @param   array                      $attribs  Unused
	 *
	 * @return  string
	 */
	public static function edit($hiot, $params, $attribs = array())
	{
		$uri = JUri::getInstance();

		if ($params && $params->get('popup'))
		{
			return;
		}

		if ($hiot->state < 0)
		{
			return;
		}

		JHtml::_('bootstrap.tooltip');

		$url	= HiotsHelperRoute::getFormRoute($hiot->id, base64_encode($uri));
		$icon	= $hiot->state ? 'edit.png' : 'edit_unpublished.png';
		$text	= JHtml::_('image', 'system/' . $icon, JText::_('JGLOBAL_EDIT'), null, true);

		if ($hiot->state == 0)
		{
			$overlib = JText::_('JUNPUBLISHED');
		}
		else
		{
			$overlib = JText::_('JPUBLISHED');
		}

		$date = JHtml::_('date', $hiot->created);
		$author = $hiot->created_by_alias ? $hiot->created_by_alias : $hiot->author;

		$overlib .= '&lt;br /&gt;';
		$overlib .= $date;
		$overlib .= '&lt;br /&gt;';
		$overlib .= htmlspecialchars($author, ENT_COMPAT, 'UTF-8');

		$button = JHtml::_('link', JRoute::_($url), $text);

		return '<span class="hasTooltip" title="' . JHtml::tooltipText('COM_HIOTS_EDIT') . ' :: ' . $overlib . '">' . $button . '</span>';
	}
}
