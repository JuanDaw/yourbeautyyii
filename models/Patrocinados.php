<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "patrocinados".
 *
 * @property int $usuario_id
 * @property int $producto_id
 *
 * @property Productos $producto
 * @property Usuarios $usuario
 */
class Patrocinados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrocinados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'producto_id'], 'required'],
            [['usuario_id', 'producto_id'], 'default', 'value' => null],
            [['usuario_id', 'producto_id'], 'integer'],
            [['usuario_id', 'producto_id'], 'unique', 'targetAttribute' => ['usuario_id', 'producto_id']],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Productos::class, 'targetAttribute' => ['producto_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usuario_id' => 'Usuario ID',
            'producto_id' => 'Producto ID',
        ];
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::class, ['id' => 'producto_id'])
            ->inverseOf('patrocinados');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])
            ->inverseOf('patrocinados');
    }
}
