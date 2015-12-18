<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\search\UserSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="user-search">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'username') ?>

		<?= $form->field($model, 'password') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'role_id') ?>

		<?php // echo $form->field($model, 'photo_url') ?>

		<?php // echo $form->field($model, 'last_login') ?>

		<?php // echo $form->field($model, 'last_logout') ?>

		<div class="form-group">
			<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
