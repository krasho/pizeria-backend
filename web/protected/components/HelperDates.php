<?php
/**
 * Created by PhpStorm.
 * User: Krasho
 * Date: 01/04/14
 * Time: 23:07
 */

class HelperDates {

    /**
     * Metodo que convierte una fecha en formato YYYY/MM/dd a d/M/YYYY
     * @param $fecha
     *
     * @return mixed
     */
    public static function getDateToFecha($fecha)
    {
        return Yii::app()->dateFormatter->formatDateTime($fecha, "medium", "");
    }

    /**
     * Metodo que convierte una fecha en formato dd/MM/YY a YYYY-MM-dd
     * @param $fecha
     *
     * @return mixed
     */
    public static function getFechaToDate($fecha)
    {

        return Yii::app()->dateFormatter->format(
            'yyyy-MM-dd',
            CDateTimeParser::parse(
                $fecha,
                'dd/MM/yyyy'
            ),
            'medium',
            ''
        );

    }

} 