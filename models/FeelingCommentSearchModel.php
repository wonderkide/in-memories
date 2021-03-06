<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FeelingCommentModel;

/**
 * FeelingCommentSearchModel represents the model behind the search form about `app\models\FeelingCommentModel`.
 */
class FeelingCommentSearchModel extends FeelingCommentModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_user_owner', 'id_comment', 'value', 'active'], 'integer'],
            [['detail', 'create_time'], 'safe'],
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
        $query = FeelingCommentModel::find();

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
            'id' => $this->id,
            'id_user' => $this->id_user,
            'id_user_owner' => $this->id_user_owner,
            'id_comment' => $this->id_comment,
            'value' => $this->value,
            'create_time' => $this->create_time,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'detail', $this->detail]);

        return $dataProvider;
    }
    public function searchNonActive($params)
    {
        $query = FeelingCommentModel::find();

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
            'id' => $this->id,
            'id_user' => $this->id_user,
            'id_user_owner' => $this->id_user_owner,
            'id_comment' => $this->id_comment,
            'value' => 1,
            'create_time' => $this->create_time,
            'active' => 0,
        ]);

        $query->andFilterWhere(['like', 'detail', $this->detail]);

        return $dataProvider;
    }
}