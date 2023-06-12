<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

// disable search engine indexing if ALLOW_SEARCH_ENGINE_INDEXING is not set to 1
if (\yii\helpers\ArrayHelper::getValue($_ENV, 'ALLOW_SEARCH_ENGINE_INDEXING', 0) != 1)
    $this->registerMetaTag(['name' => 'robots', 'content' => 'noindex, nofollow']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;500&display=swap" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100 ">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-light bg-white fixed-top']
    ]);


    $navItems = [
        ['label' => Yii::t('xenon', 'Home'), 'url' => ['/site/index']],
        ['label' => Yii::t('xenon', 'About'), 'url' => ['/site/about']],

        // add a dropdown for language selection with languages defined in Yii::$app->params['availableLocales']
        ['label' => Yii::t('xenon', 'Language'), 'items' => array_map(function ($code) {
            return [
                'label' => Yii::$app->params['availableLocales'][$code],
                'url' => ['/site/set-locale', 'locale' => $code],
                'active' => Yii::$app->language === $code
            ];
        }, array_keys(Yii::$app->params['availableLocales']))],


    ];

    if (Yii::$app->user->isGuest) {
        $navItems[] = ['label' => Yii::t('xenon', 'Login'), 'url' => ['/site/login']];
    } else {
        $navItems[] = ['label' => Yii::t('xenon', 'Logout'), 'url' => ['/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        // add a p-4 class to all menu items
        'options' => [
            'class' => 'navbar-nav text-center wedding-nav',
        ],
        'items' => $navItems
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!Yii::$app->user->isGuest && !empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
