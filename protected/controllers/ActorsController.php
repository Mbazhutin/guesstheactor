<?php

class ActorsController extends Controller
{

	public function actionIndex() {
		$this->render('index');
	}

	
	public function actionGetActors($count = 4) {
		$tmdb = new TMDb('06e865cca980ff214d3d338f9aa1fc94', 'ru');		

		// узнаем количество страниц с актерами
		$popularPersons = $tmdb->getPopulalPersons();
		$pages = $popularPersons['total_pages'];
		$actorsPerPage = count($popularPersons['results']);

		// получаем $count случайных актеров
		$result = array();
		while (count($result) < 4) {
			$page = rand(1, $pages);
			$popularPersons = $tmdb->getPopulalPersons($page)['results'];
			shuffle($popularPersons);

			foreach($popularPersons as $person) {
				if ($person['profile_path']) {
					$result[$person['id']]['photo'] = $tmdb->getImageUrl($person['profile_path'], TMDb::IMAGE_PROFILE, 'w185');
					$result[$person['id']]['name'] = $person['name'];
					break;
				}
			}	
		}

		$searchActorId = array_rand($result);
		$searchActorName = $result[$searchActorId]['name'];

		// запишем id актера в сессию чтобы потом узнать правлиьный ответ
		Yii::app()->session['actorId'] = $searchActorId;

		$this->renderPartial("actors", array('result'=>$result, 'actorName' => $searchActorName));

	}

	public function actionCheckAnswer() {
		$actorId = $_POST['actorId'];
		$correctAnswer = Yii::app()->session['actorId'];

		$success = ($correctAnswer == $actorId);
		if (!Yii::app()->user->isGuest) {
			Yii::app()->user->model->changeRating($success);
		}

		if ($success) {
			$message = "Правильно!".(!Yii::app()->user->isGuest ? " +5 рейтинга." : "");
		} else {
			$message = "К сожалению вы ошиблись.".(!Yii::app()->user->isGuest ? " -2 рейтинга." : "");
		}

		echo json_encode(array('success' => $success , 'message' => $message, 'correctAnswer' => $correctAnswer));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

}