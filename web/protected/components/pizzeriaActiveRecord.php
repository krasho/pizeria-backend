<?php
/**
 * Esta clase la creé para que todas las clases del webService, tengan los métodos
 * para manejar los errores que puedan salir en la clase
 * Created by PhpStorm.
 * User: Krasho
 * Date: 17/03/14
 * Time: 15:11
 */

class pizzeriaActiveRecord extends CActiveRecord
{
    public $camposEnElSelect;

    protected $error;
    protected $msgErrortecnico = array();
    protected $resultado;

    public $datos = array();
    public $datos2 = array();

    public function validacionErrores()
    {
        if ($this->getErrors()) {
            foreach ($this->getErrors() as $errores) {
                foreach ($errores as $error) {
                    $this->msgErrortecnico[] = $error;
                }
            }

            $this->setCodigoError(MensajeError::CODIGO_ERROR_EN_PARAMETROS_ENVIADOS);
        }

        throw new CHttpException(404, 'Error en los parámetros enviados');

    }

    /**
     * Método que asigna el error a un atributo de la clase
     * @param $error
     */
    private function setCodigoError($error)
    {
        $this->error = $error;
    }


    /***
     * Metodo que regresa el código de error encontrado
     * @return mixed
     */
    public function getCodigoError()
    {
        return $this->error;
    }

    /**
     * Méotod que regresa el texto del error, obtenido del catálogo de errores, son para los usuarios
     * @return null|string
     */
    public function getMsgError()
    {
        if (!$this->error) {
            return null;
        }

        return MensajeError::getMensajeXId($this->error);

    }

    /***
     * Método que regresa los textos de los errores encontrados, son los errores técnicos para los programadores
     * @return null|array
     */
    public function getMsgErrorTecnico()
    {
        return (!$this->msgErrortecnico) ? null : $this->msgErrortecnico;
    }

    protected function setResultadoEnArreglo()
    {
        if ($this->resultado) {
            $cont = 0;
            $this->datos = array();
            foreach ($this->resultado as $registro) {
                if (empty($this->camposEnElSelect)) {
                    $this->datos[] = $registro->attributes;
                } else {
                    $this->datos[] = $this->recorridoDeCampos($registro);
                }

                $cont++;
            }
        }
        return $this->datos;
    }

    protected function setResultadoUnRegistro()
    {
        if ($this->resultado) {
            $cont = 0;
            foreach ($this->resultado as $registro) {
                if (empty($this->camposEnElSelect)) {
                    $this->datos = $registro->attributes;
                } else {
                    $this->datos = $this->recorridoDeCampos($registro);
                }

                $cont++;
            }
        }

        return $this->datos;

    }


    protected function recorridoDeCampos($registro)
    {
        if ($this->camposEnElSelect) {
            $this->validacionesDeCamposSelect();

            $cantidadCampos = count($this->camposEnElSelect);

            $datos          = array();

            for ($cont2=0; $cont2 < $cantidadCampos; $cont2++) {
                $campo = $this->camposEnElSelect[$cont2];

                    $datos[$campo] = $registro[$campo];

            }

            return $datos;

        } else {
            $this->addError("id", "El arreglo de campos Select está vacío");
            $this->validacionErrores();
        }
    }


    private function validacionesDeCamposSelect()
    {
        if (!is_array($this->camposEnElSelect)) {
            $this->addError("id", "Los campos del select no están en formato de un arreglo");
            $this->validacionErrores();
        }
    }

    protected  function getErroresModel($model)
    {
        foreach ($model->getErrors() as $error) {
            $this->addError("id", $error);
        }

        $this->validacionErrores();
    }



} 