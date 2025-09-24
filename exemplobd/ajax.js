function ajax(){
    let tabela = document.getElementById("tabela").value;
    let url = "funcoes.php?id=0&t="+tabela;
    let xhr=new XMLHttpRequest();
    xhr.open('GET',url,true);
    xhr.onreadystatechange = function(){
        if(xhr.readyState==4){
            if(xhr.status ==200)
                document.getElementById("atributos").innerHTML=
                    xhr.responseText;
        }
    }
    xhr.send();
}