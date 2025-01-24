<?php
namespace app\models;

use yii\db\ActiveRecord;

class Tguser extends ActiveRecord
{
    // public $id;
    // public $chat_id;
    // public $user_id;
    // public $username;
    // public $step;
    // public $created_at;
    // public $updated_at;

    public static function tableName()
    {
        return '{{users}}';
    }   
    
    public function rules()
    {
        return [
            [['chat_id', 'user_id', 'step'], 'required'], 
            [['chat_id', 'user_id'], 'integer'],
            [['username'], 'string', 'max' => 255],
            [['step'], 'string', 'max' => 64],
            [['chat_id', 'user_id'], 'unique'], 
        ];
    }
}