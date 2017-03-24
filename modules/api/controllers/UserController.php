<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use app\modules\api\models\User;

/**
 * Default controller for the `api` module
 */
class UserController extends ActiveController
{
    public $modelClass = 'app\modules\api\models\User';

    public function behaviors() {
	    $behaviors = parent::behaviors();

	    // JSON response
	    $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;

	    return $behaviors;
	}

	public function actions() {
		$actions = parent::actions();

		// disable index, view, and delete actions
		unset($actions['index'], $actions['view'], $action['delete']);

    	return $actions;
	}

    // Sign up
    public function actionSignup() {
    	$user = New User();

    	$user->attributes = Yii::$app->request->post();

    	// check validation
    	if ($user->validate()) {
    		// save new user
    		$user->save();

    		return array('status' => true, 'data' => array('message' => 'Successfully signed up'));
    	} else {
    		return array('status' => false, 'data' => $user->getErrors());
    	}
    }

    public function actionSignin() {
    	// getting post data
    	$userData = Yii::$app->request->post();

    	// check if the user exists
    	$user = User::findOne(['username' => $userData['username']]);

    	if (empty($user)) {
    		throw new \yii\web\NotFoundHttpException('User not found');
    	}

    	if ($user->validatePassword($userData['password'])) {
    		// if user is valid, greet
    		return array('status' => true, 'data' => array('message' => 'Hello ' . $userData['username']));
    	} else {
    		throw new \yii\web\ForbiddenHttpException('Invalid credential');
    	}
    }

    public function actionChangepassword() {
    	// getting post data
    	$userData = Yii::$app->request->post();

    	// check if the user exists
    	$user = User::findOne(['username' => $userData['username']]);

    	if (empty($user)) {
    		throw new \yii\web\NotFoundHttpException('User not found');
    	}

    	if ($user->validatePassword($userData['password'])) {
    		if (empty($userData['new_password'])) {
    			return array('status' => false, 'data' => array('message' => 'New password required'));
    		} else {
    			// save new password
    			$user['password'] = $userData['new_password'];
    			$user->save();

    			return array('status' => true, 'data' => array('message' => 'Password successfully updated'));
    		}
    	} else {
    		throw new \yii\web\ForbiddenHttpException('Invalid credential');
    	}
    }
}
