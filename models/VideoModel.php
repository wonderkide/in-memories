<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "db_video".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $name
 * @property string $title
 * @property string $detail
 * @property string $create_date
 * @property string $update_date
 * @property integer $read
 * @property integer $show
 * @property integer $banned
 */
class VideoModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'name', 'create_date'], 'required'],
            [['id_user', 'read', 'show', 'banned'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['name'], 'string', 'max' => 128],
            [['title'], 'string', 'max' => 256],
            [['detail'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'name' => 'Name',
            'title' => 'Title',
            'detail' => 'Detail',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'read' => 'Read',
            'show' => 'Show',
            'banned' => 'Banned',
        ];
    }
}