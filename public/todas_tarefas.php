<?php
	require './tarefa_controller.php';
?>

<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>App Lista Tarefas</title>

	<link rel="stylesheet" href="css/estilo.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>

<body>
	<nav class="navbar navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="#">
				<img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
				App Lista Tarefas
			</a>
		</div>
	</nav>

	<div class="container app">
		<div class="row">
			<div class="col-sm-3 menu">
				<ul class="list-group">
					<li class="list-group-item"><a href="index.php">Tarefas pendentes</a></li>
					<li class="list-group-item"><a href="nova_tarefa.php">Nova tarefa</a></li>
					<li class="list-group-item active"><a href="todas_tarefas.php">Todas tarefas</a></li>
				</ul>
			</div>

			<div class="col-sm-9">
				<div class="container pagina">
					<div class="row">
						<div class="col">
							<h4>Todas tarefas</h4>
							<hr />
														
							<?php
								// Todo esse abre fecha abre fecha de tags php pode parecer
								// confuso, mas imagine que toda vez que preciso inserir
								// HTML, eu preciso fechar a tag PHP que você vai entender.
								// Caso não, tente deixar apenas a primeira tag php em tela
								// (com seu respectivo fechamento), e apagar o HTML, aí sim
								// com certeza você vai entender o que está acontecendo

								// Verificando se existem itens no array de tarefas
								if (count($tarefas)) {
									// Abrindo foreach
										foreach ($tarefas as $indice => $tarefa) {
										?>
											<div class="row mb-3 d-flex align-items-center tarefa">
												<div class="col-sm-9" id="tarefa_<?= $tarefa->id; ?>">
													<?= /* É aqui que a tarefa em si vai aparecer*/ $tarefa->tarefa ?>
													(<?= /* É aqui que o status da tarefa vai aparecer*/ $tarefa->status ?>)
												</div>
												<div class="col-sm-3 mt-2 d-flex justify-content-between">
													<?php
														if ($tarefa->status == 'pendente') {
															?>
														<i class="fas fa-edit fa-lg text-info"
															onclick="editar(<?= $tarefa->id ?>)"
															style="cursor: pointer;">
														</i>
														<i class="fas fa-check-square fa-lg text-success"
															onclick="marcarConcluída(<?= $tarefa->id ?>)"
															style="cursor: pointer;">
														</i>
													<?php
														}
													?>
													<i class="fas fa-trash-alt fa-lg text-danger"
														onclick="remover(<?= $tarefa->id ?>)"
														style="cursor: pointer;">
													</i>
												</div>
											</div>									
									<?php
										// Fechando foreach
										}
									?>
							<?php
								} else {
									?>
										<div class="row">
											<div class="col-12 text-center">
												<div class="alert alert-info">
													Não há nenhum item na lista de tarefas
												</div>
											</div>
										</div>
							<?php
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		function editar(idTarefa) {			
			// Verificando se o form que eu vou criar já existe (!= null)
			// Caso sim, não faz nada
			if (!document.getElementById('form-editar-tarefa')) {
				// Criando form de edição programaticamente
				const formEditaTarefa = document.createElement("form");
				formEditaTarefa.action = "tarefa_controller.php?acao=atualizar";
				formEditaTarefa.method = "post";
				formEditaTarefa.className = "form-group row";
				// Esse id é para eu checar futuramente caso o elemento exista ou não
				formEditaTarefa.id = "form-editar-tarefa";

				// Criando uma label para o input seguinte
				const labelInputTarefa = document.createElement("label");
				labelInputTarefa.for = "tarefa";
				labelInputTarefa.innerHTML = "Edite sua tarefa";
				labelInputTarefa.style = "width: 100%;";

				// Criando um input para entrada do texto
				const inputTarefa = document.createElement("input");
				inputTarefa.type = "text";
				inputTarefa.name = "tarefa";
				inputTarefa.id = "tarefa";
				inputTarefa.className = "col-8 form-control";

				// Criando um input escondido para receber no post
				const inputIdTarefa = document.createElement("input");
				inputIdTarefa.type = "hidden";
				inputIdTarefa.name = "id";
				inputIdTarefa.value = idTarefa;

				// Criando um botão programaticamente
				const btnEnviarFormEdita = document.createElement("button");
				btnEnviarFormEdita.type = "submit";
				btnEnviarFormEdita.className = "btn btn-info col-3 offset-1";
				btnEnviarFormEdita.innerHTML = "Atualizar"

				// Incluindo labelInputTarefa no formEditaTarefa
				formEditaTarefa.appendChild(labelInputTarefa);

				// Incluindo inputTarefa no formEditaTarefa
				formEditaTarefa.appendChild(inputTarefa);

				formEditaTarefa.appendChild(inputIdTarefa);

				// Incluindo botão submit no formEditaTarefa
				formEditaTarefa.appendChild(btnEnviarFormEdita);

				// Selecionar div tarefa
				const divTarefaSelec = document.querySelector("#tarefa_" + idTarefa);

				// Obtendo o antigo valor do input na div;

				// Seleciono o conteúdo interno, separo onde tem o '(' (antes do status),
				// pego o primeiro índice e então retiro espaços em branco
				const valorInputTarefa = divTarefaSelec.innerHTML.split('(')[0].trim();

				// Adicionando esse valor de input ao input de tarefas antes de inserir na div
				inputTarefa.value = valorInputTarefa;

				// Limpando conteúdo interno da div
				divTarefaSelec.innerHTML = "";

				// Adicionando o form à div
				divTarefaSelec.insertBefore(formEditaTarefa, divTarefaSelec[0]);
			}
		}

		function remover(idTarefa) {
			// Usando template string para JS moderno
			location.href = `todas_tarefas.php?acao=remover&id=${idTarefa}`;
		}

		function marcarConcluída(idTarefa) {
			// Usando template string para JS moderno
			location.href = `todas_tarefas.php?acao=concluir&id=${idTarefa}`;
		}
	</script>
</body>

</html>