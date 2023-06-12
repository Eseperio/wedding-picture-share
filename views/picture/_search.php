<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PictureSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="picture-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'filename') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'views') ?>

    <?= $form->field($model, 'likes') ?>

    <?php // echo $form->field($model, 'dislikes') ?>

    <?php // echo $form->field($model, 'shared') ?>

    <?php // echo $form->field($model, 'hidden') ?>

    <?php // echo $form->field($model, 'uploaded_from') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('xenon', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('xenon', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
