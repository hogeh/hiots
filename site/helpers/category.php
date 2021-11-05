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
 * Hiots Component Category Tree.
 *
 * @since  1.6
 */
class HiotsCategories extends JCategories
{
	/**
	 * Constructor
	 *
	 * @param   array  $options  Array of options
	 *
	 * @since   1.6
	 */
	public function __construct($options = array())
	{
		$options['table'] = '#__hiots';
		$options['extension'] = 'com_hiots';

		parent::__construct($options);
	}
}
