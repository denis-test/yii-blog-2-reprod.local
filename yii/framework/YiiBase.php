<?php

defined('YII_PATH') or define('YII_PATH',dirname(__FILE__)); //Используется в: autoload

class YiiBase
{
    public static $classMap=array(); //Используется в: autoload
    
    public static function createWebApplication($config=null)
    {
        return self::createApplication('CWebApplication',$config);
    }
    
    public static function createApplication($class,$config=null)
    {
        return new $class($config);
    }
    
    
    
    
    
    
    
    
    
    //--------------------------------------------------------------
    public static function autoload($className,$classMapOnly=false)
    {
            // use include so that the error PHP file may appear
            if(isset(self::$classMap[$className]))
                    include(self::$classMap[$className]);
            elseif(isset(self::$_coreClasses[$className]))
                    include(YII_PATH.self::$_coreClasses[$className]);
            elseif($classMapOnly)
                    return false;
            else
            {
                    // include class file relying on include_path
                    if(strpos($className,'\\')===false)  // class without namespace
                    {
                            if(self::$enableIncludePath===false)
                            {
                                    foreach(self::$_includePaths as $path)
                                    {
                                            $classFile=$path.DIRECTORY_SEPARATOR.$className.'.php';
                                            if(is_file($classFile))
                                            {
                                                    include($classFile);
                                                    if(YII_DEBUG && basename(realpath($classFile))!==$className.'.php')
                                                            throw new CException(Yii::t('yii','Class name "{class}" does not match class file "{file}".', array(
                                                                    '{class}'=>$className,
                                                                    '{file}'=>$classFile,
                                                            )));
                                                    break;
                                            }
                                    }
                            }
                            else
                                    include($className.'.php');
                    }
                    else  // class name with namespace in PHP 5.3
                    {
                            $namespace=str_replace('\\','.',ltrim($className,'\\'));
                            if(($path=self::getPathOfAlias($namespace))!==false)
                                    include($path.'.php');
                            else
                                    return false;
                    }
                    return class_exists($className,false) || interface_exists($className,false);
            }
            return true;
    }
    
    private static $_coreClasses=array( //Используется в: autoload
		'CWebApplication' => '/web/CWebApplication.php',
                'CApplication' => '/base/CApplication.php',
	);
}// End class YiiBase

spl_autoload_register(array('YiiBase','autoload'));