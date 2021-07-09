<?php

require '../private/tarefa.model.php';

require '../private/tarefa.service.php';

require '../private/db_conn.php';

// Instanciando conexao
$db_conn = new DbConnec();

// Passando por if ternário
$acao = isset($_GET['acao']) ? $_GET['acao'] : 'recuperar';

// Instanciando classe requerida
$tarefa = new Tarefa();

// Selecionando a ação passando pelo GET
switch ($acao) {
    // Você pode estar se perguntando "Por que crirar o service e a tarefa de novo?
    // Eu me perguntei a mesma coisa foi quando percebi que as coisas não eram como eu pensava,
    // logo o tarefa de inserir recebe valor de post, e o tarefa de recuperar, recebe o valor
    // do banco
    case 'inserir':
        // Definindo valor
        $tarefa->__set('tarefa', $_POST['tarefa']);

        // Instanciando serviço
        $tarefa_service = new TarefaService($db_conn, $tarefa);

        $tarefa_service->inserir();

        header('Location: nova_tarefa.php?incluido=1');
    break;
    case 'recuperar':
        // Instanciando serviço
        $tarefa_service = new TarefaService($db_conn, $tarefa);

        $tarefas = $tarefa_service->recuperar();
    break;
    case 'atualizar':
        // O índice id de POST é o input hidden e o índice tarefa é a tarefa em si
        $tarefa->__set('id', $_POST['id']);
        $tarefa->__set('tarefa', $_POST['tarefa']);

        // Instanciando serviço
        $tarefa_service = new TarefaService($db_conn, $tarefa);

        $processoAtualizarNoDB = $tarefa_service->atualizar();

        // Verificando se deu sucesso
        if ($processoAtualizarNoDB) {
            header('Location: todas_tarefas.php');
        } else {
            throw new Exception("Não foi possível atualizar a tarefa", 0);
        }
    break;
    case 'remover';
        $tarefa->__set('id', $_GET['id']);

        // Instanciando serviço
        $tarefa_service = new TarefaService($db_conn, $tarefa);

        $processoAtualizarNoDB = $tarefa_service->remover();

        // Verificando se deu sucesso
        if ($processoAtualizarNoDB) {
            header('Location: todas_tarefas.php');
        } else {
            throw new Exception("Não foi possível remover a tarefa", 0);
        }
    break;
    case 'concluir';
        $tarefa->__set('id', $_GET['id']);
        // Atualizando status para concluído
        $tarefa->__set('id_status', 2);            

        // Instanciando serviço
        $tarefa_service = new TarefaService($db_conn, $tarefa);        

        $processoAtualizarNoDB = $tarefa_service->concluir();        

        // Verificando se deu sucesso
        if ($processoAtualizarNoDB) {
            header('Location: todas_tarefas.php');
        } else {
            throw new Exception("Não foi possível concluir a tarefa", 0);
        }
    break;
    default:
        header('Location: todas_tarefas.php');
    break;
}
