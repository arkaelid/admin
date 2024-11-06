<?php
namespace Model;

class Db 
{
    static protected $pdo = null;

    public function __construct()
    {
        try {
            if (is_null(self::$pdo)) {
                self::$pdo = new \PDO(
                    "mysql:host=" . DB_HOSTNAME . ";dbname=" . DB_NAME . ";charset=utf8",
                    DB_USER,
                    DB_PASSWORD
                );
                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            }
        } catch (\PDOException $e) {
            \Controller\Error::PdoException($e);
        }
    }

    public function query($sql, $params = [])
{
    try {
        error_log("Exécution SQL: " . $sql);
        error_log("Paramètres: " . print_r($params, true));
        
        $prepare = self::$pdo->prepare($sql);
        $result = $prepare->execute($params);
        
        if (!$result) {
            error_log("Erreur SQL: " . print_r($prepare->errorInfo(), true));
        }
        
        return $prepare;
    } catch (\PDOException $e) {
        error_log("Exception PDO: " . $e->getMessage());
        throw $e;
    }
}

    public function lastInsertId()
    {
        return self::$pdo->lastInsertId();
    }

    public function prepare($sql)
    {
        return self::$pdo->prepare($sql);
    }
}
