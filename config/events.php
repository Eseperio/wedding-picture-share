<?php

// Redirect if not installed
use yii\helpers\ArrayHelper;

\yii\base\Event::on(\yii\web\Application::class, \yii\web\Application::EVENT_BEFORE_ACTION, function ($event) {
    if (!WEDDING_APP_INSTALLED && $event->action->controller->id !== 'install') {
        Yii::$app->response->redirect(['install/index']);
        Yii::$app->end();
    }
    Yii::$app->name = ArrayHelper::getValue($_ENV, 'APP_NAME', Yii::$app->name);
});


// Set application language based on $_ENV['APP_LANGUAGE'] or 'en' on application before request
\yii\base\Event::on(\yii\web\Application::class, \yii\web\Application::EVENT_BEFORE_REQUEST, function ($event) {
    $selectedLang = Yii::$app->session->get('locale');
    if ($selectedLang) {
        Yii::$app->language = $selectedLang;
    } else {
        Yii::$app->language = ArrayHelper::getValue($_ENV, 'DEFAULT_LANGUAGE_ISO_CODE', 'en');
    }
});
