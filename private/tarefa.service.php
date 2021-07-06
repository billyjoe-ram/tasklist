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

    public function atualizar($tarefa) {
        echo $tarefa;
    }

    public function remover($tarefa) {
        echo $tarefa;
    }
}