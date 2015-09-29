<?php
/* @var $this CurrencyAdminController */

$this->breadcrumbs=array(
	$this->module->id,
);

?>
<form method="get" id="dateForm" class="well form-inline" onsubmit="location = '<?= $baseUrl ?>/' + $('#date').val(); return false;">
	<div class="controls-inline">
		<label for="dateInput">Дата: </label>
		<? $this->widget(
			'bootstrap.widgets.TbDatePicker',
			[
				'name' => 'date',
				'value' => $date,
				'options' => [
					'format' => 'yyyy-mm-dd',
				],
			]
		) ?>
		<button type="submit" class="btn">Вывести</button>
	</div>
</form>

<button id="refresh" class="btn btn-success">Обновить данные</button>

<?
if ($model) {
	$this->widget(
		'bootstrap.widgets.TbExtendedGridView',
		[
			'dataProvider' => $model->search(),
			'fixedHeader' => false,
			'type' => 'striped bordered condensed',
			'responsiveTable' => true,
			'template' => "{items}",
			'ajaxUpdate' => false,

		]
	);
}
?>

<script>
$(function() {
	$('#refresh').click(function() {
		var btn = $(this);
		btn.prop('disabled', true);
		$.get('<?= $refreshUrl ?>', {date: '<?= $date ?>'}, function(data) {
			btn.prop('disabled', false);
			location.reload();
			location = location.href;
		});
	});
});
</script>
