<?php
/**
 * @var \App\View\AppView $this
 * @var \Translate\Model\Entity\TranslateProject $translateProject
 */
?>
<nav class="col-md-3 col-sm-4 col-xs-12">
	<ul class="side-nav nav nav-pills nav-stacked">
		<li class="heading"><?= __d('translate', 'Actions') ?></li>
		<li><?= $this->Html->link(__d('translate', 'List Translate Projects'), ['action' => 'index']) ?></li>
	</ul>
</nav>
<div class="translateProjects form col-md-9 col-sm-8 col-xs-12">
	<?= $this->Form->create($translateProject) ?>
	<fieldset>
		<legend><?= __d('translate', 'Add Translate Project') ?></legend>
		<?php
			echo $this->Form->control('name');
			echo $this->Form->control('type', ['options' => $translateProject::types()]);
			echo $this->Form->control('default');
			echo $this->Form->control('status', ['options' => $translateProject::statuses()]);
		?>
	</fieldset>
	<?= $this->Form->button(__d('translate', 'Submit')) ?>
	<?= $this->Form->end() ?>
</div>
