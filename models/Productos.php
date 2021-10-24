<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos".
 *
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property int $categoria_id
 * @property string $marca
 * @property string $link
 *
 * @property Patrocinados[] $patrocinados
 * @property Usuarios[] $usuarios
 * @property Categorias $categoria
 */
class Productos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'descripcion', 'categoria_id', 'marca', 'link'], 'required'],
            [['categoria_id'], 'default', 'value' => null],
            [['categoria_id'], 'integer'],
            [['nombre', 'descripcion', 'marca', 'link'], 'string', 'max' => 255],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['categoria_id' => 'id']],
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
            'descripcion' => 'Descripcion',
            'categoria_id' => 'Categoria ID',
            'marca' => 'Marca',
            'link' => 'Link',
        ];
    }

    /**
     * Gets query for [[Patrocinados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPatrocinados()
    {
        return $this->hasMany(Patrocinados::className(), ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::class, ['id' => 'usuario_id'])
            ->viaTable('patrocinados', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categorias::class, ['id' => 'categoria_id'])
            ->inverseOf('productos');
    }
}
