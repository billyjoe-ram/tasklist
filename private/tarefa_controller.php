<?php

require '../private/tarefa.model.php';

require '../private/tarefa.service.php';

require '../private/db_conn.php';

// Instanciando classe requerida
$tarefa = new Tarefa();

// Definindo valor
$tarefa->__set('tarefa', $_POST['tarefa']);

// Instanciando conexao
$db_conn = new DbConnec();

// Instanciando serviço
$tarefa_service = new TarefaService($db_conn, $tarefa);

$tarefa_service->inserir();

print_r($tarefa_service);
