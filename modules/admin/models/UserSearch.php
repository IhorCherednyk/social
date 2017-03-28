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
    public $cMessages;
    public $incomingMessage;

    public function rules() {
        return [
                [['id', 'status', 'created_at', 'updated_at', 'role', 'last_login_date'], 'integer'],
                [['username', 'email', 'password_hash', 'auth_key', 'email_activation_key', 'letterFrom', 'letterTo', 'cMessages','incomingMessage'], 'safe'],
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
//        SELECT t.*, count(*) as cMessages FROM `user` t LEFT JOIN message m ON t.id = m.sender_id GROUP BY id
//        $query = User::find();
        $query = User::find()->alias('t');
        
        
//           1. Вариант соеденения если считать только одно поле
//        $query->select(['t.*', 'count(*) as cMessages']);
//        $query->groupBy('t.id');
//        $query->leftJoin('message m', 't.id = m.sender_id');

//            2. Если кастомных полей больше одного то нужно джоинить подзапросы
        $query->select(['t.*','uc.cMessage','uc2.incomingMessage']);
        $subQuery = \app\models\Message::find()
                ->select('sender_id,COUNT(sender_id) as cMessage')
                ->groupBy('sender_id');
        $subQuery2 = \app\models\Message::find()
                ->select('recipient_id,COUNT(recipient_id) as incomingMessage')
                ->where(['status' => \app\models\Message::STATUS_UNREADED])
                ->groupBy('recipient_id');
        
        $query->leftJoin(['uc' => $subQuery], 'uc.sender_id = t.id');
        $query->leftJoin(['uc2' => $subQuery2], 'uc2.recipient_id = t.id');
        
//        echo  $query->createCommand()->getRawSql();die(); 
        
//        $query = UserGroups::find();
//        $subQuery = UserGroupRelations::find()
//            ->select('group_id, COUNT(user_id) as userCount')
//                ->groupBy('group_id');
//        
//        $query->leftJoin(['uc' => $subQuery], 'uc.group_id = id');
        
        
        
       
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->setSort([
            'attributes' => [
                'username' => [
                    'asc' => ['username' => SORT_ASC],
                    'desc' => ['username' => SORT_DESC],
                    'default' => SORT_DESC
                ],
                'userid' => [
                    'asc' => ['id' => SORT_ASC],
                    'desc' => ['id' => SORT_DESC],
                    'default' => SORT_DESC
                ],
                'email' => [
                    'asc' => ['email' => SORT_ASC],
                    'desc' => ['email' => SORT_DESC],
                    'default' => SORT_DESC
                ],
                'cMessages' => [
                    'asc' => ['cMessages' => SORT_ASC],
                    'desc' => ['cMessages' => SORT_DESC],
                    'default' => SORT_DESC
                ]
            ]
        ]);


        $this->load($params);
        
        if (!$this->validate()) {
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'role' => $this->role,
            'last_login_date' => $this->last_login_date,
        ]);
        
        $query->andFilterHaving([
            'cMessages' => $this->cMessages,
            'incomingMessage' => $this->incomingMessage
        ]);
        
        $query->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'password_hash', $this->password_hash])
                ->andFilterWhere(['like', 'auth_key', $this->auth_key])
                ->andFilterWhere(['like', 'email_activation_key', $this->email_activation_key])
                ->andFilterWhere(['between', 'id', $this->letterFrom, $this->letterTo]);
//        echo  $query->createCommand()->getRawSql();die();  
       
        return $dataProvider;
    }


}
