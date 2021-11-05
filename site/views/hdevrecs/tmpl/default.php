<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hdevrecs
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
	JLoader::register('BrewerHbeerrecipesHelper', JPATH_SITE . '/components/com_hiots/helpers/brewer.php');

JHtml::_('behavior.framework');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');


// Get the user object.
$user = JFactory::getUser();

// Check if user is allowed to add/edit based on hdevrecs permissinos.

$n = count($this->items);
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$user = JFactory::getUser();

$canEdit = $user->id==$this->device->created_by;

?>
<h2><?php echo $this->pageheading?>	</h2>
<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm">
	<?php if ($this->params->get('filter_field') != 'hide' || $this->params->get('show_pagination_limit')) : ?>
	<fieldset class="filters btn-toolbar">
		<?php if ($this->params->get('filter_field') != 'hide') : ?>
			<div class="btn-group">
				<label class="filter-search-lbl element-invisible" for="filter-search"><?php echo JText::_('COM_HIOTS_SEARCH_JSON_STRING') . '&#160;'; ?></label>
				<input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" class="inputbox" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_HIOTS_SEARCH_JSON_STRING'); ?>" placeholder="<?php echo JText::_('COM_HIOTS_SEARCH_JSON_STRING'); ?>" />
			</div>
		<?php endif; ?>
	</fieldset>
	<?php endif;?>
	<?php if ($this->params->get('show_pagination_limit')) : ?>
		<div class="btn-group pull-right">
			<?php //echo JHTML::link(JRoute::_('index.php?option=com_hiots&view=hdevrec&layout=edit&return='.base64_encode(JUri::getInstance())),JHTML::image(JURI::base().'/media/com_hiots/images/smalladd.png' , Jtext::_('COM_HIOTS_ADD')));?>
			<label for="limit" class="element-invisible">  
				<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
			</label>
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
	<?php endif; ?>

		<table class="table table-striped" id="d_blogrecList">
			<thead>
				<tr>
					<th width="10%" class="icon">
						<?php echo Jtext::_(''); ?>
					</th>
					<th width="*" class="">
						<?php echo JHtml::_('grid.sort', 'COM_HIOTS_DATE', 'a.tdate', $listDirn, $listOrder); ?>
					</th>
					<th width="60%" class="nowrap">
						<?php echo Jtext::_('COM_HIOTS_PARAMS'); ?>
					</th>
					<th width="1%" class="">
						<?php if ( $canEdit):?>
							<?php echo JHtml::_('grid.checkall'); ?>
						<?php endif; ?>
					</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($this->items as $i => $item) :?>
		<tr class= "<?php echo $class; ?>">
			<td class="icon">
				<?php if ( $canEdit):?>
					<?php echo JHTML::link(JRoute::_('index.php?option=com_hiots&view=hdevrec&id=' . (int) $item->id.'&layout=edit&return='.base64_encode(JUri::getInstance())),JHTML::image(JURI::base().'media/com_hiots/images/edit.png' , Jtext::_('COM_HIOTS_EDIT')));?>
				<?php endif; ?>
			</td>
			<td>
				<?php echo CommonHogehsHelper::showlocaltime($this->timezone,NULL,$form='d.m. H:i',$this->escape($item->tdate)); ?>
			</td>
			<td class="">
						<?php foreach ($item->params as $name => $param) :?>
							<?php if (!in_array($name, array("name", "ID", "token", "interval", "a","b","c","temp_units") ) AND $param):?>
								<?php echo JText::_(strtoupper('COM_HIOTS_'.$name)).': '.$param.'<br>';?>
							<?php endif; ?>
						<?php endforeach; ?>
			</td>
			<td class="">
				<?php if ( $canEdit):?>
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
			</tbody>
		</table>
	<?php if ( $canEdit):?>
		<div class="pull-right">
			<button type="button" class="btn" onclick="if (document.adminForm.boxchecked.value == 0) { alert('<?php echo JText::_('COM_HIOTS_SELECT_RECORDS') ?>'); } else { Joomla.submitbutton('hdevrecs.delete'); }">
				<span class="icon-delete"></span> <?php echo JText::_('COM_HIOTS_DELLETE_SELECTED') ?>
			</button>		
		</div>	
		<div class="pull-right">
			<button type="button" class="btn" onclick="Joomla.submitbutton('hdevrecs.delete_all'); ">
				<span class="icon-delete"></span> <?php echo JText::_('COM_HIOTS_DELLETE_ALL') ?>
			</button>		
		</div>	
	<?php endif; ?>
		<?php if ($this->params->get('show_pagination')) : ?>
		 <div class="pagination">
			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
				<p class="counter">
					<?php echo $this->pagination->getPagesCounter(); ?>
				</p>
			<?php endif; ?>
			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
		<?php endif; ?>
		<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="device" value="<?php echo $this->device->id;?>" />
		<input type="hidden" name="current_session_id" value="<?php echo $this->device->params->current_session_id;?>" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<input type="hidden" name="boxchecked" value="0" />
	</form>

