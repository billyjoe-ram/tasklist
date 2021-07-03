<?php

class DbConnec {
    private $host = 'localhost';
    private $nm_db = '';
    private $user = '';
    private $pass = '';

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
