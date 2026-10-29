<?php
class Conexao {
    private static $pdo = null;
    public static function conectar() {
        if (self::$pdo === null) {
            $host = 'localhost';
            $banco = 'bd_herodex_mvc';
            $usuario = 'root';
            $senha = '';
            try {
                self::$pdo = new PDO(
                    "mysql:host=$host;dbname=$banco;charset=utf8mb4",
                    $usuario,
                    $senha,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
                );
            } catch (PDOException $e) {
                die('Não foi possível conectar ao banco. Importe database.sql e confira config/conexao.php.');
            }
        }
        return self::$pdo;
    }
}
