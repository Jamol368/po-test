<?php

namespace backend\models;

use Yii;

/**
 * @property int $size
 */
class Eat extends Apple
{
    public function rules()
    {
        return [
            [['size'], 'required'],
            [['size'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'size' => 'Size',
        ];
    }
}
