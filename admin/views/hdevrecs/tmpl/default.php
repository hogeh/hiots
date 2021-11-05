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

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$canOrder	= $user->authorise('core.edit.state', 'com_hiots.category');
$saveOrder	= $listOrder == 'a.ordering';

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_hiots&task=hdevrecs.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'hdevrecList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
?>
<form action="<?php echo JRoute::_('index.php?option=com_hiots&view=hdevrecs'); ?>" method="post" name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
	<?php else : ?>
	<div id="j-main-container">
	<?php endif;?>
		<?php //echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>
		<div class="clearfix"> </div>
		<?php if (empty($this->items)) : ?>
			<div class="alert alert-no-items">
				<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
			</div>
		<?php else : ?>
			<table class="table table-striped" id="hdevrecList">
				<thead>
					<tr>
						<th width="1%" class="nowrap center hidden-phone">
							<?php echo JHtml::_('searchtools.sort', '', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
						</th>
						<th width="1%" class="nowrap center">
							<?php echo JHtml::_('grid.checkall'); ?>
						</th>
						<th width="1%" class="nowrap center">
							<?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
						</th>
						<th class="title">
							<?php echo JHtml::_('searchtools.sort', 'JGLOBAL_TITLE', 'a.tdate', $listDirn, $listOrder); ?>
						</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="8">
							<?php echo $this->pagination->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<tbody>
				<?php foreach ($this->items as $i => $item) : $item->catid=0;$item->created_by=0;$item->publish_up=""; $item->publish_down="";?>
					<?php $ordering       = ($listOrder == 'a.ordering'); ?>
					<?php $item->cat_link = JRoute::_('index.php?option=com_categories&extension=com_hiots&task=edit&type=other&cid[]=' . $item->catid); ?>
					<?php $canCreate      = $user->authorise('core.create',     'com_hiots.category.' . $item->catid); ?>
					<?php $canEdit        = $user->authorise('core.edit',       'com_hiots.category.' . $item->catid); ?>
					<?php $canCheckin     = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $user->id || $item->checked_out == 0; ?>
					<?php $canEditOwn     = $user->authorise('core.edit.own',   'com_hiots.category.' . $item->catid) && $item->created_by == $user->id; ?>
					<?php $canChange      = $user->authorise('core.edit.state', 'com_hiots.category.' . $item->catid) && $canCheckin; ?>
					<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->catid; ?>">
						<td class="order nowrap center hidden-phone">
							<?php $iconClass = ''; ?>
							<?php if (!$canChange) : ?>
								<?php $iconClass = ' inactive'; ?>
							<?php elseif (!$saveOrder) : ?>
								<?php $iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED'); ?>
							<?php endif; ?>
							<span class="sortable-handler<?php echo $iconClass ?>">
								<i class="icon-menu"></i>
							</span>
							<?php if ($canChange && $saveOrder) : ?>
								<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
							<?php endif; ?>
						</td>
						<td class="center">
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
						</td>
						<td class="center">
							<div class="btn-group">
								<?php echo JHtml::_('jgrid.published', $item->state, $i, 'hdevrecs.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
								<?php // Create dropdown items and render the dropdown list. ?>
								<?php if ($canChange) : ?>
									<?php JHtml::_('actionsdropdown.' . ((int) $item->state === 2 ? 'un' : '') . 'archive', 'cb' . $i, 'hdevrecs'); ?>
									<?php JHtml::_('actionsdropdown.' . ((int) $item->state === -2 ? 'un' : '') . 'trash', 'cb' . $i, 'hdevrecs'); ?>
									<?php echo JHtml::_('actionsdropdown.render', $this->escape($item->tdate)); ?>
								<?php endif; ?>
							</div>
						</td>
						<td class="nowrap has-context">
							<?php if ($canEdit || $canEditOwn) : ?>
								<a href="<?php echo JRoute::_('index.php?option=com_hiots&task=hdevrec.edit&id=' . (int) $item->id); ?>">
									<?php echo $this->escape($item->tdate); ?></a>
							<?php else : ?>
									<?php echo $this->escape($item->tdate); ?>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>

		<?php //Load the batch processing form. ?>
		<?php echo $this->loadTemplate('batch'); ?>

		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
