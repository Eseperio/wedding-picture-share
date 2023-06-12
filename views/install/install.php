<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\InstallForm $formModel */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="row">
        <div class="col-lg-4 offset-lg-4">
            <div class="card card-default">
                <div class="card-body">
                    <div class="card-title">
                        <?= Yii::t('xenon', 'General') ?>
                    </div>
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'layout' => ActiveForm::LAYOUT_FLOATING,

                        'fieldConfig' => [
                        ],
                    ]); ?>

                    <?= $form->field($formModel, 'siteName')->textInput(['autofocus' => true]) ?>
                    <hr>

                    <div class="card-title"><?= Yii::t('xenon', 'Admin access') ?></div>
                    <?= $form->field($formModel, 'username')->textInput() ?>

                    <?= $form->field($formModel, 'password')->passwordInput() ?>
                    <?= $form->field($formModel, 'password_repeat')->passwordInput() ?>

                    <hr>
                    <h4 class="card-title"><?= Yii::t('xenon', 'Database') ?></h4>

                    <div class="row">
                        <div class="col-8">
                            <?= $form->field($formModel, 'dbHost')->textInput() ?>
                        </div>
                        <div class="col-4">
                            <?= $form->field($formModel, 'dbPort')->textInput() ?>
                        </div>
                    </div>

                    <?= $form->field($formModel, 'dbName')->textInput() ?>
                    <?= $form->field($formModel, 'dbUser')->textInput() ?>
                    <?= $form->field($formModel, 'dbPassword')->passwordInput() ?>

                    <hr>

                    <p class="small text-muted">
                        <?= Yii::t('xenon', 'Those are the basic config params, but you can find more in your .env file') ?>
                    </p>
                    <div class="form-group">
                        <div>
                            <?= Html::submitButton('Install', ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
