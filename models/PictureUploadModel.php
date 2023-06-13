<?php

namespace app\models;

use Brick\Geo\IO\GeoJSONReader;
use Brick\Geo\IO\WKTWriter;
use Imagine\Imagick\Image;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 *
 */
class PictureUploadModel extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['file', 'file', 'extensions' => ['jpeg', 'jpg'], 'checkExtensionByMimeType' => false],
        ];
    }


    /**
     * @return bool
     */
    public function upload()
    {
        // disable logging for this action
        $oldTargets = Yii::$app->log->targets;
        Yii::$app->log->targets = [];
        try {
            if ($this->validate()) {
                $file = $this->file;
                $this->processFile($file);
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {

            $this->addError('file', $e->getMessage());
            return false;
        } finally {
            Yii::$app->log->targets = $oldTargets;
            @unlink($file->tempName);
        }
    }


    /**
     * @throws \yii\db\Exception
     */
    private function processFile(UploadedFile $file)
    {
        $filename = $file->baseName;
        // sanitize filename
        $filename = preg_replace('/[^A-Za-z0-9\-]/', '', $filename);

        $model = new Picture();
        $model->setAttributes([
            'filename' => $filename,
            'created_at' => time(),
            'uploaded_from' => Yii::$app->request->userIP,
        ]);

        try {
            $fileCreated = $model->save();
            if (!$fileCreated) {
                $this->addError('file', implode(', ', $model->getFirstErrors()));
                return;
            }
            $filepath = $model->getFullPath($model->id, '', true);
            $fileSaved = $file->saveAs($filepath);
            if (!$fileSaved) {
                $this->addError('file', 'Error al guardar el archivo');
                return;
            }
            // create a 500x500 thumbnail and store with _thumb suffix
            $thumbPath = $model->getFullPath($model->id, '-thumbnail', true);
            \yii\imagine\Image::thumbnail($filepath, 500, 500)->save($thumbPath, ['quality' => 80]);


        } catch (\Exception $e) {
            $this->addError('file', $e->getMessage());
        }
    }


}
