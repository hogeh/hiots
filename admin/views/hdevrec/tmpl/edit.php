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

JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select', null, array('disable_search_threshold' => 0 ));

// Ignore Image fieldset for the layouts as we render it manually
$this->ignore_fieldsets = array('images');

?>

<form action="<?php echo JRoute::_('index.php?option=com_hiots&view=devrec&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="hdevrec-form" class="form-validate">

		<?php echo $this->form->renderField('id'); ?>
		<?php echo $this->form->renderField('s_id'); ?>
		<?php echo $this->form->renderField('tdate'); ?>
		<?php echo $this->form->renderField('session_id'); ?>
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
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
