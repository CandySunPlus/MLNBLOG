<?php
namespace MLNPHP\Helper;

/**
 * 用户消息管理
 * 
 * @author Fengming Sun
 */
class Notice
{
    const ERROR = 'ERROR';
    const WARNING = 'WARNING';
    const NOTICE = 'NOTICE';

    public $level;
    public $message;

    /**
     * 返回所有消息
     * 
     * @param bool $del 是否同时删除
     * 
     * @return array
     */
    public static function getAll($del = false)
    {
        if (!isset($_SESSION['NOTICE'])) {
            $_SESSION['NOTICE'] = array();
        }
        $notices = $_SESSION['NOTICE'];
        if ($del) {
            unset($_SESSION['NOTICE']);
        }
        return $notices;
    }

    /**
     * 根据消息等级获取
     * 
     * @param string $level 消息等级 
     * @param bool $del 是否同时删除
     * 
     * @return array
     */
    public static function getByLevel($level, $del = false)
    {
        $return = array();
        $notices = self::getAll();
        foreach ($notices as $key => $notice) {
            if ($level == $notice->level) {
                $return[] = $notice;
                if ($del) {
                    unset($_SESSION['NOTICE'][$key]);
                }
            }
        }
        return $return;
    }

    /**
     * 添加一条
     * 
     * @param mixed $msg 消息
     * @param string $level 消息等级
     * 
     * @return Notice
     */
    public static function add($msg, $level = self::NOTICE)
    {
        if (!isset($_SESSION['NOTICE'])) {
            $_SESSION['NOTICE'] = array();
        }    
        $notice = new self($level, $msg);

        array_push($_SESSION['NOTICE'], $notice);
        return $notice;
    }

    public function __construct($level, $message)
    {
        $this->level = $level;
        $this->message = $message;
    }
}