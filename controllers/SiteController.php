<?php

namespace app\controllers;

use app\models\ContactForm;
use app\models\LoginForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

/**
 *
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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

    public function actionFake()
    {
        for ($i = 0; $i < 100; $i++) {
            $model = new \app\models\Picture();
            // get a rando timestamp between now and 30 days ago
            $timestamp = time() - rand(0, 30 * 24 * 60 * 60);
            $model->created_at = $timestamp;
            $model->views = rand(0, 1000);
            $model->filename = 'fake' . $i . '.jpg';
            $model->shared = rand(0, 1);

            $model->save();
        }
    }

    /**
     * Displays homepage.
     *
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => \app\models\Picture::find(),
            'sort' => [
                'defaultOrder' => [
//                    'created_at' => SORT_DESC
                ]
            ],
        ]);
        return $this->render('index',[
            'dataProvider'=> $dataProvider
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSetLocale($locale)
    {
        Yii::$app->session->set('locale', $locale);
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
