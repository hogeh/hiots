<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hts
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Ht Table class
 *
 * @since  1.5
 */
class HiotsTableHdevrec extends JTable
{
	/**
	 * Ensure the params and metadata in json encoded in the bind method
	 *
	 * @var    array
	 * @since  3.4
	 */
	protected $_jsonEncode = array('params');

	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver  &$db  A database connector object
	 *
	 * @since   1.5
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__hiots_records', 'id', $db);

		// Set the published column alias
		$this->setColumnAlias('published', 'state');

	}

	/**
	 * Overload the store method for the Hts table.
	 *
	 * @param   boolean  $updateNulls  Toggle whether null values should be updated.
	 *
	 * @return  boolean  True on success, false on failure.
	 *
	 * @since   1.6
	 */
	public function store($updateNulls = false)
	{
		$date = JFactory::getDate();
		$user = JFactory::getUser();

		return parent::store($updateNulls);
	}

	/**
	 * Overloaded check method to ensure data integrity.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   1.5
	 */
	public function check()
	{
	
		return true;
	}
}
