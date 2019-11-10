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
            $result = preg_replace('/(^DT)(\s*)(\w+)/', '$3', $stringLabel);
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
            $result = preg_replace('/(^NM)(\s*)(\w+)/', '$3', $stringLabel);
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
            $result = preg_replace('/(^DS)(\s*)(\w+)/', '$3', $stringLabel);
            if($result != $stringLabel){
                $result = 'Descrição '.ucfirst(strtolower($result));
            }
        }
        return $result;
    }
    //--------------------------------------------------------------------------------------
    public static function convert_st($stringLabel,$typeField)
    {
        $result = $stringLabel;
        if($typeField == TCreateForm::FORMDIN_TYPE_TEXT){
            $result = preg_replace('/(^ST)(\s*)(\w+)/', '$3', $stringLabel);
            if($result != $stringLabel){
                $result = 'Status '.ucfirst(strtolower($result));
            }
        }
        return $result;
    }
    //--------------------------------------------------------------------------------------
    public static function convert_qt($stringLabel,$typeField)
    {
        $result = $stringLabel;
        if($typeField == TCreateForm::FORMDIN_TYPE_NUMBER){
            $result = preg_replace('/(^QT)(\s*)(\w+)/', '$3', $stringLabel);
            if($result != $stringLabel){
                $result = 'Quantidade '.ucfirst(strtolower($result));
            }
        }
        return $result;
    }
    //--------------------------------------------------------------------------------------
    public static function convert_id($stringLabel,$typeField)
    {
        $result = $stringLabel;
        if($typeField == TCreateForm::FORMDIN_TYPE_NUMBER){
            $result = preg_replace('/(^ID)(\s*)(\w+)/', '$3', $stringLabel);
            if($result != $stringLabel){
                $result = 'id '.ucfirst(strtolower($result));
            }
        }
        return $result;
    }
    //--------------------------------------------------------------------------------------
    public static function convert_nr($stringLabel,$typeField)
    {
        $result = $stringLabel;
        if($typeField == TCreateForm::FORMDIN_TYPE_NUMBER){
            $result = preg_replace('/(^NR)(\s*)(\w+)/', '$3', $stringLabel);
            if($result != $stringLabel){
                $result = 'Número '.ucfirst(strtolower($result));
            }
        }
        return $result;
    }
    //--------------------------------------------------------------------------------------
    public static function convert_sao($stringLabel)
    {
        $result = preg_replace('/(\w)(sao)/i', '$1são', $stringLabel);
        return $result;
    }
    //--------------------------------------------------------------------------------------
    public static function convert_cao($stringLabel)
    {
        $result = preg_replace('/(\w)(cao)/i', '$1ção', $stringLabel);
        return $result;
    }
    //--------------------------------------------------------------------------------------
    public static function convert_gao($stringLabel)
    {
        $result = preg_replace('/(\w)(gao)/i', '$1gão', $stringLabel);
        return $result;
    }
    //--------------------------------------------------------------------------------------
    public static function remove_underline($stringLabel)
    {
        $result = preg_replace('/(_)/',' ', $stringLabel);
        return $result;
    }
    //--------------------------------------------------------------------------------------
    public static function convertLabel($stringLabel,$typeField)
    {
        $useEasyLabe = $_SESSION[APLICATIVO]['EASYLABEL'];
        if($useEasyLabe == 'Y'){
            $stringLabel = self::remove_underline($stringLabel);
            switch ($typeField) {
                case TCreateForm::FORMDIN_TYPE_DATE:
                    $stringLabel = self::convert_dt($stringLabel,$typeField);
                break;
                case TCreateForm::FORMDIN_TYPE_NUMBER:
                    $stringLabel = self::convert_qt($stringLabel,$typeField);
                    $stringLabel = self::convert_id($stringLabel,$typeField);
                    $stringLabel = self::convert_nr($stringLabel,$typeField);
                break;
                case TCreateForm::FORMDIN_TYPE_TEXT:
                    $stringLabel = self::convert_nm($stringLabel,$typeField);
                    $stringLabel = self::convert_ds($stringLabel,$typeField);
                    $stringLabel = self::convert_st($stringLabel,$typeField);
                break;
            }
            $stringLabel = self::convert_sao($stringLabel);
            $stringLabel = self::convert_cao($stringLabel);
            $stringLabel = self::convert_gao($stringLabel);
        }
        return $stringLabel;
    }
}
