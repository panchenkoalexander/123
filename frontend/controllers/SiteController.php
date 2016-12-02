<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\controllers\BaseController;



use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\Signup;
use frontend\models\Login;
use frontend\models\ContactForm;
use yii\web\Controller;

/**
 * Site controller
 */

class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */

    public function actionSignup()
    {
        $model = new Signup();
        if(isset($_POST['Signup']))
        {
            $model->attributes = Yii::$app->request->post('Signup');

            if($model->validate() &&  $model->signup() )
            {

                return $this->redirect('index');
            }
        }
        return $this->render('signup',['model'=>$model]);
    }
    public function actionLogin()
    {
        if(!Yii::$app->user->isGuest)
        {
            return $this->redirect(['index']);
        }

        $login_model = new Login();
        if(Yii::$app->request->post('Login'))
        {

            $login_model->attributes=Yii::$app->request->post('Login');
            if($login_model->validate())
            {
                Yii::$app->user->login($login_model->getUser());
                return $this->redirect('index');
            }
        }

        return $this->render('login',['login_model'=>$login_model]);
    }


    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('index');
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        return $this->render('contact');
    }

    /**
     * Displays search.
     *
     * @return mixed
     */
    public function actionSearch()
    {
        return $this->render('search');
    }

    public function actionTest()
    {
        return $this->render('test');
    }
}
