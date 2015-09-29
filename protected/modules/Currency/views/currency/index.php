<?php
/**
 * @var $this DefaultController
 * @var $model Currency
 */

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
</form><?

if ($model) {
	$this->widget(
		'bootstrap.widgets.TbExtendedGridView',
//	'zii.widgets.grid.CGridView',
		[
			'dataProvider' => $model->search(),
//		'filter' => $model,
			'fixedHeader' => false,
			'type' => 'striped bordered condensed',
			'responsiveTable' => true,
			'template' => "{items}",
			'ajaxUpdate' => false,
			'columns' => [
				[
					'name' => 'char_code',
					'header' => 'Валюта',
					'type' => 'raw',
					'value' => function (Currency $data) {
						return CHtml::tag('abbr', ['title' => $data->name_ru], $data->char_code);
					},
				],
				[
					'name' => 'cost_rub',
					'header' => 'RUB',
					'type' => 'raw',
					'value' => function (Currency $data) {
						if (!$data->cost_rub) {
							return '';
						}
						if ($data->nominal_ru > 1) {
							return CHtml::tag('abbr', ['title' => round($data->costWithNominal('rub'), 4) . ' / ' . $data->nominal_ru], round($data->cost_rub, 4));
						}
						return round($data->cost_rub, 4);
					},
				],
				[
					'name' => 'cost_uah',
					'header' => 'UAH',
					'type' => 'raw',
					'value' => function (Currency $data) {
						if (!$data->cost_uah) {
							return '';
						}
						if ($data->nominal_ua > 1) {
							return CHtml::tag('abbr', ['title' => round($data->costWithNominal('uah'), 4) . ' / ' . $data->nominal_ua], round($data->cost_uah, 4));
						}
						return round($data->cost_uah, 4);
					},
				],
			],
		]
	);
}