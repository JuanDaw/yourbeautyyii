<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre
 * @property string $password
 *
 * @property Patrocinados[] $patrocinados
 * @property Productos[] $productos
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'password'], 'required'],
            [['nombre'], 'unique'],
            [['nombre'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'password' => 'Password',
        ];
    }

    /**
     * Gets query for [[Patrocinados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPatrocinados()
    {
        return $this->hasMany(Patrocinados::class, ['usuario_id' => 'id'])
            ->inverseOf('usuario');
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::class, ['id' => 'producto_id'])
            ->viaTable('patrocinados', ['usuario_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['nombre' => $username]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
    
    }

    public function validateAuthKey($authKey)
    {
    
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword(
            $password,
            $this->password
        );
    }
}
