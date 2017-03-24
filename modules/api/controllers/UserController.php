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

    // Sign up
    public function actionSignup() {
    	// JSON response
    	Yii::$app->response->format = Response::FORMAT_JSON;

    	$user = New User();

    	$user->attributes = Yii::$app->request->post();

    	if ($user->validate()) {
    		$user->save();

    		return array('status' => true, 'data' => array('message' => 'Successfully signed up'));
    	} else {
    		return array('status' => false, 'data' => $user->getErrors());
    	}
    }

    public function actionSignin() {
    	// JSON response
    	Yii::$app->response->format = Response::FORMAT_JSON;

    	$userData = Yii::$app->request->post();

    	$user = User::findOne(['username' => $userData['username']]);

    	if (empty($user)) {
    		throw new \yii\web\NotFoundHttpException('User not found');
    	}

    	if ($user->validatePassword($userData['password'])) {
    		return array('status' => true, 'data' => array('message' => 'Hello ' . $userData['username']));
    	} else {
    		throw new \yii\web\ForbiddenHttpException('Invalid credential');
    	}
    }

    public function actionChangepassword() {
    	// JSON response
    	Yii::$app->response->format = Response::FORMAT_JSON;

    	$userData = Yii::$app->request->post();

    	$user = User::findOne(['username' => $userData['username']]);

    	if (empty($user)) {
    		throw new \yii\web\NotFoundHttpException('User not found');
    	}

    	if ($user->validatePassword($userData['password'])) {
    		if (empty($userData['new_password'])) {
    			return array('status' => false, 'data' => array('message' => 'New password required'));
    		} else {
    			$user['password'] = $userData['new_password'];
    			$user->save();

    			return array('status' => true, 'data' => array('message' => 'Password successfully updated'));
    		}
    	} else {
    		throw new \yii\web\ForbiddenHttpException('Invalid credential');
    	}
    }
}
