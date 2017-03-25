<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Message;

/**
 * MessageSearch represents the model behind the search form about `app\models\Message`.
 */
class MessageSearch extends Message
{
    public $type;
    public $username;


    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'sender_id', 'recipient_id','type'], 'integer'],
            [['text','username'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    public function search($params)
    {
        
        $query = Message::find();
        
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        
        if($this->type == Message::MESSAGE_INCOMING){
            $query->where(['=', 'recipient_id', Yii::$app->user->id]);
            $query->joinWith('sender');
        }else {
            $query->where(['=', 'sender_id', Yii::$app->user->id]);
            $query->joinWith('recipient');
        }
        
        
       
        if (!$this->validate()) {
            return $dataProvider;
        }
        
        
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sender_id' => $this->sender_id,
            'recipient_id' => $this->recipient_id,
            'text' => $this->text
        ]);
//        D($query->createCommand()->getSql());
       
        $query->andFilterWhere(['like', 'username', $this->username]);
//        D($query->createCommand()->sql);
        return $dataProvider;
    }
}