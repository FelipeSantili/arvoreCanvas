<?php
require_once "funcoes.php";
$fun = new funcoes();
  $tabelas= $fun->selecionarTabela();
?>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário com Select</title>
   <link rel="stylesheet" href="estilo.css">
    <script src="ajax.js"></script>
</head>
<body>
<form action="funcoes.php?id=1" method="post">
    <label for="tabela">Escolha uma tabela:</label>
    <select id="tabela" name="tabela" onchange="ajax()">
        <option></option>
        <?php
          foreach ($tabelas as $tabela){
                 echo("<option>".$tabela."</option>");
          }
        ?>

    </select>

    <label for="atributo">Escolha o atributo Objetivo:</label>
    <select id="atributos" name="atributos">

    </select>

    <button type="submit">Enviar</button>
</form>
</body>
</html>
