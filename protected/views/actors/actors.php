<h2> 
	Угадайте актера по имени - <?php echo $actorName;?>
</h2>

<div id="photoContainer">
	<?php
		foreach($result as $actor=>$info) {
			echo CHtml::link(
				CHtml::image($info['photo']),
				'#',
				array('class' => 'photo unknown', 'data-id' => $actor)
			);
			
		}
	?>
</div>

<a href="javascript:void(0);" id="loadActors"> Попробовать еще </a>

<h2 id="answer"></h2>