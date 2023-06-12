<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class InstallController extends Controller
{
    /**
     * @param \app\controllers\SiteController $this
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionIndex()
    {
        if (WEDDING_APP_INSTALLED) {
            return $this->goHome();
        }

        $formModel = new \app\models\InstallForm();
        if ($formModel->load(Yii::$app->request->post()) && $formModel->validate()) {
            $formModel->install();
            return $this->redirect(['after-install']);
        }

        return $this->render('install', [
            'formModel' => $formModel
        ]);
    }

    /**
     * @return void|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function actionAfterInstall()
    {
        if (!WEDDING_APP_INSTALLED) {
            return $this->goHome();
        }
        try {// run system migrations

            // define STD_OUT to null if not defined
            // this is needed for the migration to run in web app
            // because the default console commands outputs to STDOUT

            if (!defined('STDOUT')) {
                define('STDOUT', fopen('/dev/null', 'w'));
            }

            $migration = new \yii\console\controllers\MigrateController('migrate', Yii::$app);
            $migration->runAction('up', ['migrationPath' => '@app/migrations', 'interactive' => false]);
        } catch (\Throwable $e) {
            unlink(Yii::getAlias('@app/.env'));

            if (YII_DEBUG) {
                throw $e;
            } else {
                Yii::$app->session->setFlash('error', 'Error al ejecutar la instalación de la base de datos. Se revertió la instalación');
                Yii::error($e->getMessage());
                return $this->goHome();
            }

        }
        return $this->goHome();
    }
}
