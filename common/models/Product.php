<?php

namespace common\models;

use Yii;
use dektrium\user\models\User;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $category_id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $category
 * @property User $user
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id'], 'integer'],
            [['name', 'created_at', 'updated_at'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['user_id', 'category_id'], 'filter', 'filter' => function ($value) {
                return ($value === '' ? null : (int)$value);
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'value' => function () { return date('Y-m-d H:i:s'); },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'category_id' => Yii::t('app', 'Category'),
            'name' => Yii::t('app', 'Name'),

            'user.username' => Yii::t('app', 'User'),
            'category.name' => Yii::t('app', 'Category'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
       return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
