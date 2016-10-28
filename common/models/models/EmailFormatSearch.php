<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmailFormat;

/**
 * EmailFormatSearch represents the model behind the search form about `common\models\EmailFormat`.
 */
class EmailFormatSearch extends EmailFormat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iEmailFormatId'], 'integer'],
            [['vEmailFormatTitle', 'vEmailFormatType', 'vEmailFormatSubject', 'tEmailFormatDesc', 'vDescriptionDisplay', 'vTags'], 'safe'],
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
        $query = EmailFormat::find();

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
            'iEmailFormatId' => $this->iEmailFormatId,
        ]);

        $query->andFilterWhere(['like', 'vEmailFormatTitle', $this->vEmailFormatTitle])
            ->andFilterWhere(['like', 'vEmailFormatType', $this->vEmailFormatType])
            ->andFilterWhere(['like', 'vEmailFormatSubject', $this->vEmailFormatSubject])
            ->andFilterWhere(['like', 'tEmailFormatDesc', $this->tEmailFormatDesc])
            ->andFilterWhere(['like', 'vDescriptionDisplay', $this->vDescriptionDisplay])
            ->andFilterWhere(['like', 'vTags', $this->vTags]);

        return $dataProvider;
    }
}
