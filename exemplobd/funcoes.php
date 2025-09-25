<?php
require_once "conexao.php";
class funcoes{
    private $con;

    public function __construct() {
        $this->con = (new Conexao())->conectar();
    }

    public function selecionarTabela() {
        $sql = "SHOW TABLES";
        $stmt = $this->con->query($sql);

        $tabelas = [];
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $tabelas[] = $row[0];
        }
        return $tabelas;
    }

    public function selecionarAtributos($tabela){
        $sql = "SHOW COLUMNS FROM " . $tabela;
        $atributos = $this->con->query($sql)->fetchAll(PDO::FETCH_OBJ);
        $attr = "";
        foreach ($atributos as $atributo) {
            $attr .= "<option>".$atributo->Field."</option>";
        }
        echo $attr;
    }

    public function grupoPorAtributo(){
        $tbl = $_POST["tabela"];
        $classe = "quarto_escolhido";
        $atributos = $this->getAtributos($tbl);

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
        $entropias = [];
        foreach ($atributos as $atrib) {
            // ignora id, codigo e a classe
            if (!in_array($atrib, ["id", "codigo", $classe])) {
                $entropias[$atrib] = $this->calcularEntropia($tbl, $atrib, $classe);
            }
        }

        // mostrar todas as entropias
        echo "<h3>Entropias por atributo:</h3>";
        echo "<table border='1' cellpadding='5'><tr><th>Atributo</th><th>Entropia</th></tr>";
        foreach ($entropias as $atrib => $val) {
            echo "<tr><td>{$atrib}</td><td>{$val}</td></tr>";
        }
        echo "</table><br>";

        asort($entropias);
        $raiz = key($entropias);
        $valor = current($entropias);

        echo "<h3>O atributo escolhido como raiz é <b>{$raiz}</b> porque sua entropia foi <b>{$valor}</b></h3>";
    }

    private function getAtributos($tabela){
        $sql = "SHOW COLUMNS FROM {$tabela}";
        $atributos = $this->con->query($sql)->fetchAll(PDO::FETCH_OBJ);
        $cols = [];
        foreach ($atributos as $a) {
            $cols[] = $a->Field;
        }
        return $cols;
    }

    private function calcularEntropia($tabela, $atributo, $classe){
        $sql = "SELECT DISTINCT {$atributo} FROM {$tabela}";
        $valores = $this->con->query($sql)->fetchAll(PDO::FETCH_COLUMN);

        $totalRegistros = $this->con->query("SELECT COUNT(*) FROM {$tabela}")->fetchColumn();
        $entropiaTotal = 0;

        foreach ($valores as $valor) {
            $sql = "SELECT COUNT(*) FROM {$tabela} WHERE {$atributo} = " . $this->con->quote($valor);
            $totalGrupo = $this->con->query($sql)->fetchColumn();

            $sql = "SELECT {$classe}, COUNT(*) as qtd 
                    FROM {$tabela} 
                    WHERE {$atributo} = " . $this->con->quote($valor) . " 
                    GROUP BY {$classe}";
            $classes = $this->con->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $entropiaGrupo = 0;
            foreach ($classes as $c) {
                $p = $c["qtd"] / $totalGrupo;
                if ($p > 0) {
                    $entropiaGrupo += -$p * log($p, 2);
                }
            }

            $entropiaTotal += ($totalGrupo / $totalRegistros) * $entropiaGrupo;
        }

        return round($entropiaTotal, 4);
    }
}

if(isset($_REQUEST["id"])){
    if($_REQUEST["id"]==0)
        (new funcoes())->selecionarAtributos($_REQUEST["t"]);
    else if($_REQUEST["id"]==1)
        (new funcoes())->grupoPorAtributo();
}
