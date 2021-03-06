<?php
// +----------------------------------------------------------------------
// | Phalbee Support
// +----------------------------------------------------------------------
// | Copyright (c) 2015 https://github.com/fenghuilee/phalbee-core All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( MIT )
// +----------------------------------------------------------------------
// | Author: Fenghui Lee <fenghuilee@gmail.com>
// +----------------------------------------------------------------------

/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
function dump($var, $echo=true, $label=null, $strict=true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}


/**
 * 将下划线命名转换为驼峰式命名
 * @param string $var 变量
 * @param boolean $ucfirst 是否首字符大写 默认为true
 * @return string
 */
function convert_to_camel_case_format( $var , $ucfirst = true ) {
    $var = ucwords(str_replace('_', ' ', $var));
    $var = str_replace(' ','',lcfirst($var));
    return $ucfirst ? ucfirst($var) : $var;
}

/**
 * 获取一个变量的setter方法名(驼峰式命名)
 * @param string $var 变量
 * @return string
 */
function setter( $var ) {
    return 'set' . convert_to_camel_case_format( $var , true );
}

/**
 * 获取一个变量的getter方法名(驼峰式命名)
 * @param string $var 变量
 * @return string
 */
function getter( $var ) {
    return 'get' . convert_to_camel_case_format( $var , true );
}