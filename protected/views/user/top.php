<?php

$this->pageTitle=Yii::app()->name . ' - Топ';

?>

<h2> Топ участников </h2>

Топ участников:

<?php
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider' => $model->search(),
		'columns' => array(
		    'name',
		    'rating',       
		),
	));
?>