<?php

/** @var yii\web\View $this */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <?= $this->render('upload-button') ?>

    <?= \app\widgets\PicturesListView::widget([
        'dataProvider' => $dataProvider,
    ]) ?>
</div>
