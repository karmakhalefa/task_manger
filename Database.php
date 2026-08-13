<?php

class Database
{
        private static $instance;
    // بينات الاتصال 
    private $host = '127.0.0.1';
    private $dbname = 'task manger ';
    private $username = 'root';
    private $password = '';
// هنخزن الاتصال هنا 
    private $connection;
// الـ Constructor هي function PHP بتشغلها تلقائيًا أول ما تعملي object من الكلاس.
 private function __construct()
    {  
        $this->connection = new PDO(
            "mysql:host={$this->host};dbname={$this->dbname}",
            $this->username,
            $this->password
        );
    } 
    // هاتلي النسخة من الداتا بيز
    public static function getInstance()
    {
        // لو مش موجود اعمل نسخه لو موجوده  رجعها 
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

// دي فانكشن بترجع الاتصال لباقي الفانكشنز ف تطبيق لان الاتصال برايفت 
    public function getConnection()
    {
        return $this->connection;
    }
}