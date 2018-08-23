<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "db_video_item".
 *
 * @property integer $id
 * @property integer $id_video
 * @property string $title
 * @property string $detail
 * @property string $path
 * @property string $thumbnail
 * @property integer $sorting
 */
class VideoItemModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_video_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_video', 'path', 'sorting'], 'required'],
            [['id_video', 'sorting'], 'integer'],
            [['title'], 'string', 'max' => 128],
            [['detail'], 'string', 'max' => 512],
            [['path', 'thumbnail'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_video' => 'Id Video',
            'title' => 'Title',
            'detail' => 'Detail',
            'path' => 'Path',
            'thumbnail' => 'Thumbnail',
            'sorting' => 'Sorting',
        ];
    }
}