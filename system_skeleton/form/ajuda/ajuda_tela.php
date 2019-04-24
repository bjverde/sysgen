<?php
require_once("../includes/constantes.php");
$msgSysNameVersion = SYSTEM_NAME.' - v'.SYSTEM_VERSION;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Ajuda - <?php echo $msgSysNameVersion; ?></title>
</head>
<body>
    <h2>Ajuda - <?php echo $msgSysNameVersion; ?></h2>
    <h3>Tela padrão</h3>
    <br>
    <br>
    <br><h4>Descrição da tela</h4>
    <ul>
      <li>Campos</li>
      <li>Botões de ação</li>
      <li>Lista de registro com ações por registro</li>
    </ul>
    <br>
    <br><h4>Detalhe das ações</h4>
    <ul>
      <li>Buscar - informe um valor em um ou mais campos, que serão utilizados como critérios de busca. Na lista de registro aparecerá apenas os registros que respeitam a busca. Se informar mais de um campo eles serão usados com E. Logo a Pesquisa será "Quero todos os registro com o <b>campo a E o campo B</b></li>
      <li>Salvar - informe todos os campos e poderá gravar um novo registro. Se clicar no botão altera da lista de registro os valores serão enviados para os campos. Depois poderá alterar esse registro</li>
      <li>Limpar - limpa os valores que estão nos campos</li>
    </ul>
    <br>
    <br><h4>Ações da listra de registro</h4>
    <ul>
      <li>Alterar - Carrega todos os valores do registro para os campos. Possibilitando a sua alteração</li>
      <li>Excluir - Exclui o registro selecionado</li>
      <li>Exportar - Exporta os registro na tela para o formato XLS</li>
      <li>Ordenar - Poder ordenar por qualquer coluna, porém apenas entre os registros aparecem na tela</li>
    </ul>
</body>
</html>