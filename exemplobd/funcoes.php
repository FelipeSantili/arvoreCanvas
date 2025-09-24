<?php
require_once "conexao.php";
class funcoes{
    private $con;

    public function __construct()    {
        $this->con = (new Conexao())->conectar();
    }
    public function selecionarTabela()    {
        $sql = "SHOW TABLES";
        $stmt = $this->con->query($sql);

        $tabelas = [];
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $tabelas[] = $row[0];
        }
        return $tabelas;
    }
    public function selecionarAtributos($tabela){
        $sql = "show columns from " . $tabela;
        $atributos = $this->con->query($sql)->fetchAll(PDO::FETCH_OBJ);
        $attr = "";
        foreach ($atributos as $atributo) {
            $attr .= "<option>".$atributo->Field."</option>";
        }
        echo $attr;
    }

    private function calcularEntropia($dados, $classe){
        $total = count($dados);
        if($total == 0) return 0;

        $contagem = [];
        foreach($dados as $dado){
            $valorClasse = $dado->$classe;
            if(!isset($contagem[$valorClasse])){
                $contagem[$valorClasse] = 0;
            }
            $contagem[$valorClasse]++;
        }

        $entropia = 0;
        foreach($contagem as $c){
            $p = $c / $total;
            if($p > 0) $entropia -= $p * log($p, 2);
        }
        return $entropia;
    }

    private function entropiaPorAtributo($tbl, $classe){
        $sql = "show columns from {$tbl}";
        $atributos = $this->con->query($sql)->fetchAll(PDO::FETCH_OBJ);

        $sqlAll = "select * from {$tbl}";
        $dados = $this->con->query($sqlAll)->fetchAll(PDO::FETCH_OBJ);
        $total = count($dados);
        $entropias = [];

        foreach($atributos as $atributo){
            $attr = $atributo->Field;
            if($attr == $classe) continue;

            $sql = "SELECT DISTINCT {$attr} FROM {$tbl}";
            $valores = $this->con->query($sql)->fetchAll(PDO::FETCH_OBJ);

            $soma = 0;
            foreach($valores as $v){
                $valor = $v->$attr;
                $grupo = array_filter($dados, function($d) use ($attr, $valor){
                    return (string)$d->$attr === (string)$valor;
                });
                $countGrupo = count($grupo);
                if($countGrupo == 0) continue;
                $entGrupo = $this->calcularEntropia($grupo, $classe);
                $soma += ($countGrupo / $total) * $entGrupo;
            }

            $entropias[$attr] = round($soma, 4);
        }

        return $entropias;
    }

    public function grupoPorAtributo(){
        $classe = $_POST["atributos"];
        $tbl = $_POST["tabela"];

        $sql = "SELECT DISTINCT {$classe} FROM {$tbl};";
        $val = $this->con->query($sql)->fetchAll(PDO::FETCH_OBJ);
        echo "<h3>Grupos por '{$classe}':</h3>";
        echo "<table border='1'>";
        foreach ($val as $v){
            $valorFiltro = isset($v->$classe) ? $v->$classe : "";
            $sql="select * from {$tbl} where {$classe}='".$valorFiltro."'";
            $dados = array_values($this->con->query($sql)->fetchAll(PDO::FETCH_OBJ));
            echo "<tr>";
            foreach ($dados as $dado){
                echo "<td>";
                foreach ($dado as $campo =>$valor){
                    echo "$campo: $valor<br>";
                }
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        $entropias = $this->entropiaPorAtributo($tbl, $classe);

        echo "<h3>Entropias por atributo:</h3>";
        echo "<table border='1'><tr><th>Atributo</th><th>Entropia</th></tr>";
        foreach($entropias as $atrib => $valor){
            echo "<tr><td>{$atrib}</td><td>{$valor}</td></tr>";
        }
        echo "</table>";

        if(count($entropias) > 0){
            $minVal = min($entropias);
            $menorAttrArr = array_keys($entropias, $minVal);
            $menorAttr = $menorAttrArr[0];
            $menorVal = $entropias[$menorAttr];
            echo "<p><b>O atributo escolhido como raiz é {$menorAttr} porque sua entropia foi {$menorVal}.</b></p>";
        } else {
            echo "<p>Nenhum atributo disponível para cálculo de entropia.</p>";
        }
    }
}
if(isset($_REQUEST["id"])){
    if($_REQUEST["id"]==0)
        (new funcoes())->selecionarAtributos($_REQUEST["t"]);
    else if($_REQUEST["id"]==1)
        (new funcoes())->grupoPorAtributo();
}
