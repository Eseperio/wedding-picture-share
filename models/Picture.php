<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "picture".
 *
 * @property int $id
 * @property string $filename
 * @property int $created_at
 * @property int $views
 * @property int $likes
 * @property int $dislikes
 * @property int $shared
 * @property int $hidden
 * @property string $uploaded_from
 */
class Picture extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'picture';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['filename', 'created_at', 'uploaded_from'], 'required'],
            [['created_at', 'views', 'likes', 'dislikes', 'shared', 'hidden'], 'integer'],
            [['filename'], 'string', 'max' => 255],
            [['uploaded_from'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('xenon', 'ID'),
            'filename' => Yii::t('xenon', 'Filename'),
            'created_at' => Yii::t('xenon', 'Created At'),
            'views' => Yii::t('xenon', 'Views'),
            'likes' => Yii::t('xenon', 'Likes'),
            'dislikes' => Yii::t('xenon', 'Dislikes'),
            'shared' => Yii::t('xenon', 'Shared'),
            'hidden' => Yii::t('xenon', 'Hidden'),
            'uploaded_from' => Yii::t('xenon', 'Uploaded From'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PictureQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PictureQuery(get_called_class());
    }

    /**
     * Returns the full path for the given picture id by
     * exploding the id numbers into a path structure.
     * I.e: 1234567 -> 1/2/3/4/5/6/7
     * @param $id
     * @param bool $autoCreate
     * @return string
     * @throws \yii\base\Exception
     */
    public function getFullPath($id, $autoCreate = false)
    {
        $uploadPath = Yii::getAlias('@webroot/uploads');
        $path = implode('/', str_split($id));
        $dir = $uploadPath . '/' . $path;
        FileHelper::createDirectory($dir);

        return $dir . '/' . $id . '.jpg';
    }

    public function getThumbnailUrl()
    {
        return "https://picsum.photos/300/300?random=" . $this->id;
    }
}
