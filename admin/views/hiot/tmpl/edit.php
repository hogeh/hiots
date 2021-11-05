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

JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select', null, array('disable_search_threshold' => 0 ));

// Ignore Image fieldset for the layouts as we render it manually
$this->ignore_fieldsets = array('images');

JFactory::getDocument()->addScriptDeclaration("
	Joomla.submitbutton = function(task)
	{
		if (task == 'hiot.cancel' || document.formvalidator.isValid(document.getElementById('hiot-form'))) {
			" . $this->form->getField('description')->save() . "
			Joomla.submitform(task, document.getElementById('hiot-form'));
		}
	};
");
?>

<form action="<?php echo JRoute::_('index.php?option=com_hiots&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="hiot-form" class="form-validate">

	<?php echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', empty($this->item->id) ? JText::_('COM_HIOTS_NEW_IOT', true) : JText::_('COM_HIOTS_EDIT_IOT', true)); ?>
		<div class="row-fluid">
			<div class="span9">
				<div class="form-vertical">
					<?php echo $this->form->renderfield('token'); ?>
					<?php echo $this->form->renderfield('iot_type'); ?>
					<?php echo $this->form->renderfield('description'); ?>
				</div>
			</div>
			<div class="span3">
				<?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'images', JText::_('JGLOBAL_FIELDSET_IMAGE_OPTIONS', true)); ?>
			<div class="row-fluid">
				<div class="span6">
					<?php echo $this->form->renderfield('images'); ?>
					<?php foreach ($this->form->getGroup('images') as $field) : ?>
						<?php echo $field->renderfield(); ?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'params', JText::_('JGLOBAL_FIELDSET_PARAMETER', true)); ?>
		<?php $fieldSets = $this->form->getFieldsets('params');?>
		<?php foreach ($fieldSets as $name => $fieldSet) : ?>
			<?php if((substr($name,0,4)<>'type') OR  ((substr($name,0,4)=='type') AND (substr($name,4,1)==$this->item->iot_type))): ?>
				<div class="tab-pane" id="params-<?php echo $name; ?>">
				<h3><?php echo JText::_($fieldSet->label);?></h3>
				<?php if (isset($fieldSet->description) && trim($fieldSet->description)) : ?>
					<?php echo '<p class="alert alert-info">' . $this->escape(JText::_($fieldSet->description)) . '</p>'; ?>
				<?php endif; ?>
				<?php foreach ($this->form->getFieldset($name) as $field) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $field->label; ?></div>
						<div class="controls"><?php echo $field->input; ?></div>
					</div>
				<?php endforeach; ?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php echo JHtml::_('bootstrap.endTab'); ?>



		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('JGLOBAL_FIELDSET_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla.edit.publishingdata', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla.edit.metadata', $this); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

	</div>

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
