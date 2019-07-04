<?php
/**
 * SysGen - System Generator with Formdin Framework
 * Download Formdin Framework: https://github.com/bjverde/formDin
 *
 * @author  Bjverde <bjverde@yahoo.com.br>
 * @license https://github.com/bjverde/sysgen/blob/master/LICENSE GPL-3.0
 * @link    https://github.com/bjverde/sysgen
 *
 * PHP Version 5.6
 */


class EasyLabel
{
    public function __construct()
    {
    }
    //--------------------------------------------------------------------------------------
    public static function convert_dt($stringLabel,$typeField)
    {
        $result = $stringLabel;
        if($typeField == TCreateForm::FORMDIN_TYPE_DATE){
            $result = preg_replace('/(DT)(\w)/', '$2', $stringLabel);
            if($result != $stringLabel){
                $result = 'Data '.ucfirst(strtolower($result));
            }            
        }
        return $result;
    }
    //--------------------------------------------------------------------------------------
    public static function convert_nm($stringLabel,$typeField)
    {
        $result = $stringLabel;
        if($typeField == TCreateForm::FORMDIN_TYPE_TEXT){
            $result = preg_replace('/(NM)(\w)/', '$2', $stringLabel);
            if($result != $stringLabel){
                $result = 'Nome '.ucfirst(strtolower($result));
            } 
        }
        return $result;
    }
    //--------------------------------------------------------------------------------------
    public static function convert_ds($stringLabel,$typeField)
    {
        $result = $stringLabel;
        if($typeField == TCreateForm::FORMDIN_TYPE_TEXT){
            $result = preg_replace('/(DS)(\w)/', '$2', $stringLabel);
            if($result != $stringLabel){
                $result = 'Descrição '.ucfirst(strtolower($result));
            }
        }
        return $result;
    }
    //--------------------------------------------------------------------------------------
    public static function convert_qt($stringLabel,$typeField)
    {
        $result = $stringLabel;
        if($typeField == TCreateForm::FORMDIN_TYPE_NUMBER){
            $result = preg_replace('/(QT)(\w)/', '$2', $stringLabel);
            if($result != $stringLabel){
                $result = 'Quantidade '.ucfirst(strtolower($result));
            }
        }
        return $result;
    }
    //--------------------------------------------------------------------------------------
    public static function convertLabel($stringLabel,$typeField)
    {
        $useEasyLabe = $_SESSION[APLICATIVO]['EASYLABEL'];
        if($useEasyLabe == 'Y'){
            switch ($typeField) {
                case TCreateForm::FORMDIN_TYPE_DATE:
                    $stringLabel = self::convert_dt($stringLabel,$typeField);
                break;
                case TCreateForm::FORMDIN_TYPE_NUMBER:
                    $stringLabel = self::convert_qt($stringLabel,$typeField);
                    break;
                case TCreateForm::FORMDIN_TYPE_TEXT:
                    $stringLabel = self::convert_nm($stringLabel,$typeField);
                    $stringLabel = self::convert_ds($stringLabel,$typeField);
                break;
            }
        }
        return $stringLabel;
    }
}
