<?php
/**
 * 异步操作mysql
 */
namespace app\common;

class Mysqlasync
{
    const HOST = '127.0.0.1';
    const PORT = 3306;
    const USER = 'root';
    const PWD = 'hkj123';
    const DATABASE = 'yao_store';
    const CHARSET = 'utf8';
    
    private static $obj = null;
    
//     private static $db = null;
    
//     public function __construct(){
//         self::$db = new \swoole_mysql();
//         self::$db->connect([
//             'host' => self::HOST,
//             'port' => self::PORT,
//             'user' => self::USER,
//             'password' => self::PWD,
//             'database' => self::DATABASE,
//             'charset' => self::CHARSET,
//         ], function($db, $r){
//             if ($r === false) {
//                 var_dump($db->connect_errno, $db->connect_error);
//                 die;
//             }
//         });
//     }
    
    public static function getInstance(){
        if (empty(self::$obj)){
            self::$obj = new self();
        }
        return self::$obj;
    }
    
    public function query($sql){
        $db = new \swoole_mysql();
        $db->connect([
            'host' => self::HOST,
            'port' => self::PORT,
            'user' => self::USER,
            'password' => self::PWD,
            'database' => self::DATABASE,
            'charset' => self::CHARSET,
        ], function($db, $r) use ($sql){
            if ($r === false) {
                var_dump($db->connect_errno, $db->connect_error);
                die;
            }
            $db->query($sql, function($db, $r){
                if ($r === false)
                {
                    var_dump($db->error, $db->errno);
                }
                $db->close();
            });
        });
    }
}