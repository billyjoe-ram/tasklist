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

// Passando por if ternário
$acao = isset($_GET['acao']) ? $_GET['acao'] : 'recuperar';

// Se o post veio, se o campo tarefa do post não está vazio
// if (isset($_POST['tarefa']) && !empty($_POST['tarefa'])) {    

        
// }

// Selecionando a ação passando pelo GET
switch ($acao) {
    case 'inserir':
        $tarefa_service->inserir();

        header('Location: nova_tarefa.php?incluido=1');
    break;
    case 'recuperar':
        $tarefa_service->recuperar();
    break;
}
