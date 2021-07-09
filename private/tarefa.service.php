<?php

class TarefaService {

    private $conexao;
    private $tarefa;

    public function __construct(DbConnec $conexao, Tarefa $tarefa) {
        $this->conexao = $conexao->conectar();
        $this->tarefa = $tarefa;
    }

    public function inserir() {
        $query = "insert into tb_tarefas(tarefa) values(:tarefa)";
        // Statement
        $stmt = $this->conexao->prepare($query);

        $stmt->bindValue(":tarefa", $this->tarefa->__get("tarefa"));

        $stmt->execute();
    }

    public function recuperar() {
        $query = "
            select t.id, sts.status, t.tarefa
                from tb_tarefas as t
            left join tb_status as sts
                on (t.id_status = sts.id)
        ";
        // Preparando um statement com a query
        $stmt = $this->conexao->prepare($query);

        // Executando PDOStatement
        $stmt->execute();
        // Buscando todos como objeto
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function atualizar() {
        $query = 'update tb_tarefas set tarefa = :tarefa where id = :id';

        // Não esqueça que é esse statemente do PDO que vai ajudar a prevenir SQL Injection
        $stmt = $this->conexao->prepare($query);

        $stmt->bindValue(":tarefa", $this->tarefa->__get("tarefa"));
        $stmt->bindValue(":id", $this->tarefa->__get("id"));

        return $stmt->execute();
    }

    public function remover() {
        $query = "delete from tb_tarefas where id = :id";

        $stmt = $this->conexao->prepare($query);

        $stmt->bindValue(":id", $this->tarefa->__get("id"));

        return $stmt->execute();
    }

    public function concluir() {
        $query = 'update tb_tarefas set id_status = :id_status where id = :id';

        // Não esqueça que é esse statemente do PDO que vai ajudar a prevenir SQL Injection
        $stmt = $this->conexao->prepare($query);

        $stmt->bindValue(":id_status", $this->tarefa->__get("id_status"));
        $stmt->bindValue(":id", $this->tarefa->__get("id"));

        return $stmt->execute();
    }
}