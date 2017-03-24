<?php

namespace app\modules\admin\models;

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
    public $letterFrom;
    public $letterTo;
    public $sendmessage;

    public function rules() {
        return [
                [['id', 'status', 'created_at', 'updated_at', 'role', 'last_login_date'], 'integer'],
                [['username', 'email', 'password_hash', 'auth_key', 'email_activation_key', 'letterFrom', 'letterTo', 'sendmessage'], 'safe'],
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
    public function search($params) {

//        SELECT t.id, t.email, m.sender_id, count(*) as cMessages FROM `user` t LEFT JOIN message m ON t.id = m.sender_id GROUP BY id

        $query = User::find();


//        $query->select(['t.*', 'm.*', 'count(*) as cMessages']);
//        $query->groupBy('sender_id');
//        $query->leftJoin('message m','t.id = m.sender_id');
//        echo  $query->createCommand()->getRawSql();die();   
//        $query->joinWith('messagesSender');





        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if (empty($dataProvider->sort->getAttributeOrders())) {
            $dataProvider->query->orderBy(['id' => SORT_DESC]);
        }
        
//        $dataProvider->setSort([
//            'attributes' => [
//                'sendmessage' => [
//                    'asc' => ['sendmessage' => SORT_ASC],
//                    'desc' => ['sendmessage' => SORT_DESC],
//                    'label' => 'Send Message',
//                    'default' => SORT_ASC
//                ],
//            ]
//        ]);
        $this->load($params);



//        $sendmessage = $query->count($this->id = $this->)

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'role' => $this->role,
            'last_login_date' => $this->last_login_date,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'password_hash', $this->password_hash])
                ->andFilterWhere(['like', 'auth_key', $this->auth_key])
                ->andFilterWhere(['like', 'email_activation_key', $this->email_activation_key])
                ->andFilterWhere(['between', 'id', $this->letterFrom, $this->letterTo]);

        return $dataProvider;
    }

}
