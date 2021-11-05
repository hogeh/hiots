<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hiots
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.framework');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');


// Get the user object.
$user = JFactory::getUser();

// Check if user is allowed to add/edit based on hiots permissinos.
$canEdit = $user->authorise('core.edit', 'com_hiots.category.' . $this->category->id);
$canCreate = $user->authorise('core.create', 'com_hiots');
$canEditState = $user->authorise('core.edit.state', 'com_hiots');

$n = count($this->items);
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
?>

<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm">
	<?php if ($this->params->get('filter_field') != 'hide' || $this->params->get('show_pagination_limit')) : ?>
		<fieldset class="filters btn-toolbar">
			<?php if ($this->params->get('filter_field') != 'hide') : ?>
					<label class="filter-search-lbl element-invisible" for="filter-search"><?php echo JText::_('COM_HIOTS_FILTER_LABEL') . '&#160;'; ?></label>
					<input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="inputbox" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_HIOTS_FILTER_SEARCH_DESC'); ?>" placeholder="<?php echo JText::_('COM_HIOTS_FILTER_SEARCH_DESC'); ?>" />
			<?php endif; ?>
		</fieldset>
	<?php endif;?>
	<?php if ($this->params->get('show_pagination_limit')) : ?>
		<div class="btn-group pull-right">
			<label for="limit" class="element-invisible">  
				<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
			</label>
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
	<?php endif; ?>
	
		<table class="table table-striped" id="d_blogrecList">
			<thead>
				<tr>
					<th width="5%" class="nowrap ">
						<?php echo JHtml::_('grid.sort', 'ID', 'a.id', $listDirn, $listOrder); ?>
					</th>
					<th width="20%" class="nowrap">
						<?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
					</th>
					<th width="10%" class="hidden-phone">
						<?php echo Jtext::_('COM_HIOTS_TYPE'); ?>
					</th>
					<th width="20%" class="nowrap">
						<?php echo Jtext::_('JGLOBAL_FIELDSET_PARAMETER'); ?>
					</th>
					<th width="10%" class="">
						<?php echo JHtml::_('grid.sort', 'COM_HIOTS_DATE', 'a.created', $listDirn, $listOrder); ?>
					</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($this->items as $i => $item) :?>
				<tr class= "<?php echo $class; ?>">
						<td>
							<?php echo $item->id; ?>
						</td>
					<td class="">
					<?php if ($canEdit):?>
					<?php endif; ?>
							<?php echo ($this->escape($item->title)) ?>
					</td>
					<td class= "hidden-phone">
						<?php $params=json_decode($item->params);?>
						<?php 	$param=$item->params;?>

						<?php switch($item->iot_type){
							case 0: echo JText::_('COM_HIOTS_ISPINDEL');break;
							case 1: echo JText::_('COM_HIOTS_MESHCONTROLLER');break;
							case 2: echo JText::_('COM_HIOTS_HEATING'); break;
							case 3: echo JText::_('COM_HIOTS_COOLING'); break;
							case 4: echo JText::_('');break;
						} ?>
					</td>
					<td class="">
							<?php echo ($this->escape($param)) ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
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
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	</form>

