<?php

class DbConnec {
    // Salvei algumas configurações padrão, você pode alterar isso no seu arquivo caso queira
    private $host = 'localhost';
    private $nm_db = 'php_tasklist';
    private $user = 'dev';
    private $pass = 'DevelopingInPHP.7';

    public function conectar() {
        try {
            $conexao = new PDO(
                "mysql:host=$this->host;dbname=$this->nm_db",
                "$this->user",
                "$this->pass"
            );

            return $conexao;
        } catch (PDOException $e) {
            echo '<p>' . $e->getMessage() . '</p>';
        }
    }
}
