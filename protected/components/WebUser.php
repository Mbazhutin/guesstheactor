<?php 
class WebUser extends CBehavior {
    private $_model = null; 
    function getUsername() {
        if($user = $this->getModel()){
            // в таблице User есть поле role
            return $user->username;
        }
    }
    function getRating() {
        if($user = $this->getModel()){
            // в таблице User есть поле ban
            return $user->rating;
        }
    }
    function getName() {
        if($user = $this->getModel()){
            // в таблице User есть поле active
            return $user->name;
        }
    }
 
    function getModel(){
        if (!Yii::app()->user->isGuest && $this->_model === null){
            $this->_model = User::model()->findByPk(Yii::app()->user->id,array('select'=>'rating, username, name'));
        }
        return $this->_model;
    }
} 