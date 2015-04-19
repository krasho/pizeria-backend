<?php $this->layout="/layouts/login"; ?>

<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
	)); ?>

    <div id="panelLogin">
        <div id="panelLoginTop">

            <div id = "img-login">
            </div>

            <div class="row">
				<?php
				echo $form->label($model,'username');
				echo $form->textField($model,"username");
				echo $form->error($model,'username');
				?>

            </div>
            <div class="row">
				<?php
				echo $form->label($model,'password');
				echo $form->passwordField($model,'password');
				echo $form->error($model,'password');
				?>
            </div>

            <div class="buttons">
                <?php echo TbHtml::submitButton('Iniciar sesión', array('color' => TbHtml::BUTTON_COLOR_INVERSE));?>
            </div>
        </div>
    </div>
	<?php $this->endWidget(); ?>
</div>

<?php //$this->pageTitle=Yii::app()->name; ?>

