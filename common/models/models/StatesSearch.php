<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\States;

/**
 * StatesSearch represents the model behind the search form about `common\models\States`.
 */
class StatesSearch extends States
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iStateId'], 'integer'],
            [['vStateName', 'eStatus', 'iCountryId'], 'safe'],
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
        $query = States::find();

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

        $query->joinWith('countryName');
        // grid filtering conditions
        $query->andFilterWhere([
            'iStateId' => $this->iStateId,

        ]);
        /*$query->andFilterWhere([
            'iStateId' => $this->iStateId,
            'iCountryId' => $this->iCountryId,
        ]);*/

        $query->andFilterWhere(['like', 'vStateName', $this->vStateName])
            ->andFilterWhere(['like', 'eStatus', $this->eStatus])
            ->andFilterWhere(['like', 'countries.vCountryName', $this->iCountryId]);

        return $dataProvider;
    }
}
