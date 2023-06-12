<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Picture $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="picture-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'filename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'views')->textInput() ?>

    <?= $form->field($model, 'likes')->textInput() ?>

    <?= $form->field($model, 'dislikes')->textInput() ?>

    <?= $form->field($model, 'shared')->textInput() ?>

    <?= $form->field($model, 'hidden')->textInput() ?>

    <?= $form->field($model, 'uploaded_from')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('xenon', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
