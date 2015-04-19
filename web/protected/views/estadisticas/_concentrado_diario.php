<?php
/**
 * Created by PhpStorm.
 * User: joseluis
 * Date: 01/04/14
 * Time: 19:20
 */
?>
<div class="wide form">
<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                   => 'Solicitud-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'type'                 => TbHtml::FORM_LAYOUT_HORIZONTAL,
        /*'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),*/
    )
);

?>
<div class="control-group">
    <label class="control-label" for="dia">
        <?php echo $model->getAttributeLabel('dia');?>
    </label>
    <div class="controls">
    <?php
    $this->widget(
        'zii.widgets.jui.CJuiDatePicker',
        array(
            'model' => $model,
            'attribute' => 'dia',
            'options' => array(
                'language' => 'es',
                'dateFormat' => 'dd/mm/yy',

            )
        )
    );

    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'type'       => 'primary',
            'label'      => 'Buscar'
        )
    );

    ?>
    </div>
</div>
<?php
$this->endWidget();
?>
</div>

<?php
if ($model->dia) {
    $this->widget(
        'zii.widgets.jui.CJuiAccordion',
        array(
            'id'      => 'accordeon-asignar',
            'panels'  => array(
                'Total de Ventas por Sucursal'   => $this->renderPartial(
                    "_montos_x_sucursal",
                    array('model' => $resumenPorSucursal),
                    true
                ),
                'Total de Ventas por Repartidor' => $this->renderPartial(
                    "_montos_x_repartidor",
                    array('model' => $resumenPorRepartidor),
                    true
                ),
                'Preferencias de Productos'      => $this->renderPartial(
                    "_preferencias_pedidos",
                    array('model' => $pedidos),
                    true
                ),
            ),
            'options' => array(
                'animated' => 'bounceslide',
            ),
        )
    );
}