<?php

class UserController extends Controller
{
	
	public function actionIndex() {
		$model = User::model()->findByPk(Yii::app()->user->id);

		if (!$model)
			$this->redirect('/guesstheactor/site/login');

		if (isset($_POST['User'])) {
			$model->attributes = $_POST['User'];
			$model->save();
		}

		$this->render('index', array('model' => $model));
	}

	public function actionTop() {
		$model = new User('search');
		$this->render('top', array('model' => $model));
	}		
}