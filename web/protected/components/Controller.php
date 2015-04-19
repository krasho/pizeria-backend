<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();


    //Atributo que contiene los datos enviados desde el cliente
    public $campos;

    //Este atributo es variable dependiendo del controlador que se llame si está vacio el arreglo no se necesita validar
    public $objeto;

    //Arreglo que se regresa
    public $datos = array("error"=>"0","datos"=>array(),"msg"=>'','msgTecnico'=>'');

    /**
     * Este método regresa el id del usuario loggeado
     */
    public function getIdUsuario()
    {
        return Yii::app()->session['idUsuario'];
    }


    /**
     * Este método valida los datos enviados por el cliente
     */
    public function validaDatos()
    {
        $this->campos = CJSON::decode($_REQUEST['datos'], true);

        if ($this->validarClavesAcceso() != true ||
            $this->validaParametros() != true ) {

            //Se llenan las descripciones de los errores
            $this->setMsgError();
            return false;
        }

        return true;

    }


    /***
     * Método que valida que las claves de acceso estén correctas
     * @return bool
     */
    private function validarClavesAcceso()
    {
        $usuario  =(isset($this->campos['datos']['usuario'])) ? $this->campos['datos']['usuario']:"" ;
        $password =(isset($this->campos['datos']['password'])) ? $this->campos['datos']['password']:"" ;

        if (ValidacionUsuarioPermitido::validar($usuario, $password) == false) {
            $this->datos['error'] = MensajeError::CODIGO_ERROR_EN_USUARIO_Y_PASSWORD;
            return false ;
        }

        return true;
    }

    /***
     * Método que valida que exista el arreglo con los datos
     * @return bool
     */

    private function validaParametros()
    {
        if (isset($this->objeto) &&  !isset($this->campos['datos'][$this->objeto])) {
            $this->datos['error'] = MensajeError::CODIGO_ERROR_PARAMETROS_INSUFICIENTES;
            return false;
        }
        return true;
    }

    /**
     * Método que llena la sección de errores, para esta parte el mensaje y el mensaje técnico son los mismos
     */
    private function setMsgError()
    {
        $this->datos['msg'] = MensajeError::getMensajeXId($this->datos['error']);

        $vError    = $this->datos['msg'];

        //No se encontró el arreglo
        if ($this->datos['error'] ==  MensajeError::CODIGO_ERROR_PARAMETROS_INSUFICIENTES) {
            $vError    = "No se encontró el arreglo [ $this->objeto ] en el JSON";
        }

        $this->datos['msgTecnico'][] = $vError;
    }


    /***
     * Método que regresa el arreglo con los errores en caso de que sean de las validaciones comunes
     * @return array
     */
    public function getErrores()
    {
        return $this->datos;
    }


    public function validaErroresDelTry($model, $e)
    {
        if (empty($model) or $model->getCodigoError() == "") {
            $this->datos['error']      = MensajeError::CODIGO_ERROR_AL_PROCESAR_LA_SOLICITUD;
            $this->datos['msg']        = MensajeError::getMensajeXId(MensajeError::CODIGO_ERROR_AL_PROCESAR_LA_SOLICITUD);
            $this->datos['msgTecnico'][] = $e->getMessage();
        } else {
            $this->datos['error']      = MensajeError::CODIGO_ERROR_AL_PROCESAR_LA_SOLICITUD;
            $this->datos['msg']          = $model->getMsgError();

            $r = $model->getMsgErrorTecnico();

            if (is_array($r)) {
                $this->datos['msgTecnico']   = $r;
            } else {
                $this->datos['msgTecnico'][] = $r;
            }

        }
    }
}