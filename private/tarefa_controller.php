<?php

require '../private/tarefa.model.php';

require '../private/tarefa.service.php';

require '../private/db_conn.php';

// Instanciando conexao
$db_conn = new DbConnec();

// Passando por if ternário
$acao = isset($_GET['acao']) ? $_GET['acao'] : 'recuperar';

// Selecionando a ação passando pelo GET
switch ($acao) {
    // Você pode estar se perguntando "Por que crirar o service e a tarefa de novo?
    // Eu me perguntei a mesma coisa foi quando percebi que as coisas não eram como eu pensava,
    // logo o tarefa de inserir recebe valor de post, e o tarefa de recuperar, recebe o valor
    // do banco
    case 'inserir':
        // Instanciando classe requerida
        $tarefa = new Tarefa();

        // Definindo valor
        $tarefa->__set('tarefa', $_POST['tarefa']);

        // Instanciando serviço
        $tarefa_service = new TarefaService($db_conn, $tarefa);

        $tarefa_service->inserir();

        header('Location: nova_tarefa.php?incluido=1');
    break;
    case 'recuperar':
        $tarefa = new Tarefa();

        // Instanciando serviço
        $tarefa_service = new TarefaService($db_conn, $tarefa);

        $tarefas = $tarefa_service->recuperar();
    break;
}
