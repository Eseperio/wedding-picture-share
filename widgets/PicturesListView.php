<?php

namespace app\widgets;

use app\assets\AppAsset;
use kop\y2sp\ScrollPager;
use Yii;
use yii\helpers\Html;
use yii\widgets\ListView;

class PicturesListView extends ListView
{
    public $pager = [
        'class' => ScrollPager::class,
    ];

    public function init()
    {
        $this->emptyText = $this->getDefaultEmptyText();
        parent::init();
    }

    /**
     * @param $model \app\models\Picture
     * @param $key
     * @param $index
     * @return void
     */
    public function renderItem($model, $key, $index)
    {

        // items are Picture objects. Render the picture as a bootstrap 5 card, displaying the view count and the
        // picture itself.

        $image = Html::img($model->getThumbnailUrl(), ['class' => 'card-img-top']);
        $heartAsciiIcon = '&#x2665;';
        $image .= Html::tag('div', $heartAsciiIcon . $model->views, ['class' => 'metadata']);
        $card = Html::tag('div', $image, ['class' => 'card']);
        $card = Html::a($card, ['picture/view', 'id' => $model->id]);
        return Html::tag('div', $card, ['class' => 'col-md-4 mb-4']);

    }

    private function getDefaultEmptyText()
    {
        // get AppAsset published path
        $bundle = Yii::$app->assetManager->getBundle(AppAsset::class);
        $imgUrl = Yii::$app->assetManager->getAssetUrl($bundle, 'imgs/photo-camera.svg');
        $img = Html::img($imgUrl, [
            'class' => 'opacity-25 img-fluid w-50',
        ]);
        $label = Html::tag('div', Yii::t('xenon', 'Ok, seems like there is no pictures yet. Be the first to upload one'), ['class' => 'text-muted text-center mt-2']);
        return '<div class="row"><div class="col-md-4 offset-md-4 text-center">' . $img . $label . '</div></div>';
    }
}
