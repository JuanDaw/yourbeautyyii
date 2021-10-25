<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Productos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="productos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Productos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',
            'descripcion',
            'categoria_id',
            'categoria.nombre::Categoría',
            'marca',
            'link',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{favorito}',
                'buttons' => [
                    'favorito' => function ($url, $model, $key) {
                        return Html::a('Añadir a favoritos', [
                            'usuarios/favoritos',
                            'id' => $key,
                        ], 
                        ['class' => 'btn-sm btn-danger']
                        );
                    },
                ]
            ],
        ],
    ]); ?>


</div>