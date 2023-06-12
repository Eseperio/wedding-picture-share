<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Wedding Picture sharer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <div class="row">
        <div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3">

            <div class="card card-body">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
                <p>
                    <?= Yii::t('xenon', 'Wedding picture sharer is an application lovely created by {brand}', [
                        'brand' => Html::a('Waizabú', 'https://waizabu.com', ['target' => '_blank'])
                    ]) ?>
                </p>
                <hr>
                <?= Html::a('Waizabú', 'https://waizabu.com', [
                    'target' => '_blank',
                    'class' => 'btn btn-outline-secondary w-100'
                ]) ?>

            </div>
        </div>
    </div>
</div>
