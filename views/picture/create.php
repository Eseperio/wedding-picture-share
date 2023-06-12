<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Picture $model */

$this->title = Yii::t('xenon', 'Create Picture');
$this->params['breadcrumbs'][] = ['label' => Yii::t('xenon', 'Pictures'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="picture-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
