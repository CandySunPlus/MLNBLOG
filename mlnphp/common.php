<?php
/**
 * 所有公用函数
 * common.php
 */
use \MLNPHP\MLNPHP;

/**
 * 调试函数，MLNPHP::debug的别名函数
 *
 * @return void
 */
function debug()
{
    $args = func_get_args();
    MLNPHP::debug($args);
}
