<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rubric".
 *
 * @property int $id
 * @property string $name
 */
class Rubric extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rubric';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public function getNews()
    {
        return $this->hasMany(News::className(), ['rubric_id' => 'id']);
    }
}
