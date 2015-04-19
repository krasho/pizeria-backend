<?php

$this->widget(
    'zii.widgets.jui.CJuiAccordion',
    array(
        'id'      => 'accordeon-asignar',
        'panels'  => array(
            'Ventas' => $this->renderPartial("_comparativa", array(), true),
        ),
        'options' => array(
            'animated' => 'bounceslide',
        ),
    )
);
