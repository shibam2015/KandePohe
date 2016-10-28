<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MasterHeight;

/**
 * MasterHeightSearch represents the model behind the search form about `common\models\MasterHeight`.
 */
class MasterHeightSearch extends MasterHeight
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iHeightID'], 'integer'],
            [['vName', 'eStatus'], 'safe'],
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
        $query = MasterHeight::find();

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
            'iHeightID' => $this->iHeightID,
        ]);

        $query->andFilterWhere(['like', 'vName', $this->vName])
            ->andFilterWhere(['like', 'eStatus', $this->eStatus]);

        return $dataProvider;
    }
}
