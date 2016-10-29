<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Wightege;

/**
 * WightegeSearch represents the model behind the search form about `common\models\Wightege`.
 */
class WightegeSearch extends Wightege
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iWightege'], 'integer'],
            [['vWightegeName', 'vWightegePercent'], 'safe'],
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
        $query = Wightege::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'iWightege' => $this->iWightege,
        ]);

        $query->andFilterWhere(['like', 'vWightegeName', $this->vWightegeName])
            ->andFilterWhere(['like', 'vWightegePercent', $this->vWightegePercent]);

        return $dataProvider;
    }
}
