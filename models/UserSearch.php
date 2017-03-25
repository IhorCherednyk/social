<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['username', 'email', 'password_hash', 'auth_key', 'email_activation_key'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params, $user) {
        $query = User::find();


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            
            'pagination' => [
                'pageSize' => 3,
            ],
        ]);

        $this->load($params);
        
        $query->where(['!=', 'id', \Yii::$app->user->id])->andWhere(['!=', 'id', $user->id])->andWhere(['=', 'status', User::STATUS_ACTIVE])
                ->andWhere(['!=', 'role', User::IS_ADMIN]);
//        D($query->createCommand()->getSql());


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'role' => $this->role,
            'last_login_date' => $this->last_login_date,
        ]);
        
        $query->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }

}
