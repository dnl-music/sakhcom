<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $short_desc
 * @property string $created_at
 * @property string $image
 * @property string $content
 * @property int $rubric_id
 * @property int $likes
 */
class News extends \yii\db\ActiveRecord
{
    public $upload;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'short_desc', 'rubric_id'], 'required'],
            [['content'], 'string'],
            [['rubric_id', 'likes'], 'integer'],
            [['title', 'short_desc', 'image'], 'string', 'max' => 255],
            [['created_at'], 'string', 'max' => 45],
            [['upload'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'short_desc' => 'Short Desc',
            'created_at' => 'Created At',
            'image' => 'Image',
            'content' => 'Content',
            'rubric_id' => 'Rubric',
            'likes' => 'Likes',
        ];
    }
    public function getRubric()
    {
        return $this->hasOne(Rubric::className(), ['id' => 'rubric_id']);
    }
}
