<?php

namespace backend\models;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "apples".
 *
 * @property int $id
 * @property string $color
 * @property int $created_at
 * @property int|null $fallen_at
 * @property int $status
 * @property float|null $size
 */
class Apple extends \yii\db\ActiveRecord
{
    public const IN_TREE = 1;

    public const FALLEN = 2;

    public $colors = ['red', 'white'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apples';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color', 'created_at', 'status'], 'required'],
            [['created_at', 'fallen_at', 'status'], 'integer'],
            [['size'], 'number'],
            [['color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Color',
            'created_at' => 'Created At',
            'fallen_at' => 'Fallen At',
            'status' => 'Status',
            'size' => 'Size',
        ];
    }

    public function getColor()
    {
        return $this->colors[random_int(0, count($this->colors) - 1)];
    }

    public static function getStatuses()
    {
        return [
            self::IN_TREE => 'In tree',
            self::FALLEN => 'Fallen',
        ];
    }

    public function getStatus()
    {
        return $this::getStatuses()[$this->status];
    }

    public function getRandStatus()
    {
        $rand = array_rand($this::getStatuses());

        if ($rand === self::FALLEN) {
            $this->fallen_at = time();
        }

        return $rand;
    }

    public function eat($size)
    {
        if ($this->status === self::IN_TREE) {
            Yii::$app->session->setFlash('error', 'Съесть нельзя, яблоко на дереве');
        } else if ($this->status === self::FALLEN && $this->checkRotten()) {
            $this->size -= (float)($size/100);
            $this->save();
            Yii::$app->session->setFlash('success', 'Success');
        } else {
            Yii::$app->session->setFlash('error', 'Съесть нельзя, гнилое яблоко');
        }
    }

    public function checkRotten()
    {
        return $this->fallen_at >= (time() - (5 * 60 * 60)) ? true : false;
    }

    public function deleteIf()
    {
        if ($this->size <= 0) {
            $this->delete();
        }
    }
}
