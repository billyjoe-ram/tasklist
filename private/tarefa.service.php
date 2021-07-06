<?php

class TarefaService {

    private $conexao;
    private $tarefa;

    public function __construct(DbConnec $conexao, Tarefa $tarefa) {
        $this->conexao = $conexao->conectar();
        $this->tarefa = $tarefa;
    }

    public function inserir() {
        $query = 'insert into tb_tarefas(tarefa) values(:tarefa)';
        $stmt = $this->conexao->prepare($query);

        $stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));

        $stmt->execute();
    }

    public function recuperar() {
        echo "Recuperando";
    }

    public function atualizar($tarefa) {
        echo $tarefa;
    }

    public function remover($tarefa) {
        echo $tarefa;
    }
}