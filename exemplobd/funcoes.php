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
    public function grupoPorAtributo(){
        $attr = $_POST["atributos"];
        $tbl = $_POST["tabela"];
        $sql = "SELECT DISTINCT {$attr} FROM {$tbl};";
        $val = $this->con->query($sql)->fetchAll(PDO::FETCH_OBJ);
        echo "<table border='1'>";
        foreach ($val as $v){
            $sql="select * from {$tbl} where {$attr}='".$v->$attr."'";
            $dados = array_values($this->con->query($sql)->fetchAll(PDO::FETCH_OBJ));
            echo "<tr>";
            foreach ($dados as $dado){
                echo "<td>";
                foreach ($dado as $campo =>$valor){
                    echo "$campo: $valor<br>";
                }
                echo "</td>";
            }
            echo "<tr>";
        }
        echo "</table>";

    }
}
if(isset($_REQUEST["id"])){
    if($_REQUEST["id"]==0)
        (new funcoes())->selecionarAtributos($_REQUEST["t"]);
    else if($_REQUEST["id"]==1)
        (new funcoes())->grupoPorAtributo();

}

