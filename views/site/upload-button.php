<?php


/* @var $this \yii\web\View */
?>


<?php
echo \dosamigos\fileupload\FileUploadUI::widget([
    'model' => new \app\models\PictureUploadModel(),
    'attribute' => 'file',
    'url' => ['/picture/handle-upload'],
    // limit filetypes to .geojson and .sld
    'gallery' => false,
    'fieldOptions' => [
        'accept' => 'application/geojson,application/vnd.ogc.sld+xml',
        'multiple' => true,
    ],
    'clientOptions' => [
        'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(geojson|sld|jpeg|jpg|pdf)$/i'),
        // limit to 10 MB
        'maxFileSize' => 10 * 1024 * 1024,
        'sequentialUploads' => true,
        'deleteUrl' => 'delete-file',
        'removeAfterUpload' => true,

        'messages' => [
            'maxNumberOfFiles' => 'Máximo número de archivos excedido',
            'acceptFileTypes' => 'Tipo de archivo no permitido',
            'maxFileSize' => 'Archivo demasiado grande.',
            'minFileSize' => 'Archivo demasiado pequeño'
        ],
    ],
    'clientEvents' => [
        'fileuploaddone' => new \yii\web\JsExpression(<<<JS
function(e, data) {
    console.log(data);
                        // Check if the upload was successful
                            if (data.result && data.result.success) {
                                // Remove the file row from the DOM
                            $(data.context).remove();
                                }
                            return true;
                        }
JS
        ),
    ],

])
?>

