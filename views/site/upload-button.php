<?php


/* @var $this \yii\web\View */
?>


<div id="upload-progress" class="progress">
    <div class="progress-bar bg-secondary progress-bar-success"></div>
</div>

<?php
echo \dosamigos\fileupload\FileUpload::widget([
    'model' => new \app\models\PictureUploadModel(),
    'attribute' => 'file',
    'plus' => true,
    'url' => ['/picture/handle-upload'],
    'options' => [
        'accept' => 'image/jpeg',
        'multiple' => true,
    ],
    'clientOptions' => [
        'progressall' => new \yii\web\JsExpression(<<<JS

function(e, data) {
        console.log("asads");
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $("#upload-progress .progress-bar").css(
                "width",
                progress + "%"
            );
        }
JS
        ),
        // when all files are uploaded, redirect to index page
        'done' => new \yii\web\JsExpression(<<<JS
function(e, data) {
            location.reload();
        }
JS
        ),
    ],


])
?>

