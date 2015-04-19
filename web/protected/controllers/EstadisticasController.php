<?php
/**
 * Created by PhpStorm.
 * User: joseluis
 * Date: 01/04/14
 * Time: 18:55
 */

class EstadisticasController extends Controller{

    const TAB_PREDEFINIDO = 1;
    /**
     * Declaracion de los actions
     */
    public function actions()
    {
        return array(
            'index' => 'application.controllers.estadisticas.indexAction',
        );
    }

    /***
     * @param $tab
     * @return array
     */
    public function validaTab($tab)
    {

        $arrayTab = array("tab1" => true, "tab2" => false, "tab3" => false);

        if ($tab == 1 or $tab == 2 or $tab == 3) {
            for ($cont = 1; $cont < 4; $cont++) {
                ($cont == $tab) ? $arrayTab['tab' . $cont] = true : $arrayTab['tab' . $cont] = false;
            }

        }
        return $arrayTab;
    }

} 