<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;
use dektrium\user\models\User;

/**
 * ProductSearch represents the model behind the search form about `common\models\Product`.
 */
class ProductSearch extends Product
{
    public $created_from;
    public $created_to;
    public $updated_from;
    public $updated_to;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'category_id'], 'integer'],
            [['name'], 'safe'],
            [['created_from', 'created_to', 'updated_from', 'updated_to'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Product::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $query->joinWith(['user']);
        $dataProvider->sort->attributes['user.username'] = [
            'asc'  => ['{{%user}}.username' => SORT_ASC],
            'desc' => ['{{%user}}.username' => SORT_DESC],
        ];

        $query->joinWith(['category']);
        $dataProvider->sort->attributes['category.name'] = [
            'asc'  => ['{{%category}}.name' => SORT_ASC],
            'desc' => ['{{%category}}.name' => SORT_DESC],
        ];

        $this->load($params);

        // add default sorting
        if (empty($dataProvider->sort->getAttributeOrders())) {
            $dataProvider->query->orderBy(['{{%product}}.id' => SORT_DESC]);
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        $query->andFilterWhere(['>=', '{{%product}}.created_at', $this->created_from]);
        $query->andFilterWhere(['<=', '{{%product}}.created_at', $this->created_to]);
        $query->andFilterWhere(['>=', '{{%product}}.updated_at', $this->updated_from]);
        $query->andFilterWhere(['<=', '{{%product}}.updated_at', $this->updated_to]);

        return $dataProvider;
    }
}
