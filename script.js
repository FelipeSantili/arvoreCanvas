const canvas = document.getElementById("c");
const ctx = canvas.getContext("2d");
const pares=[
         [null,"A"],
         ["A","B"],
         ["A","C"],
         ["B","D"],
         ["B","E"],
         ["F","C"],
         ["G","C"],
];
const filhos ={};
for(const [p,f] of pares){
    if(!filhos[p]) filhos[p]=[];
    filhos[p].push(f);
}
const niveis={};
const pos={};
let raiz = pares.find(p=>p[0]===null)[1];
function  bfs() {
    const fila = [[raiz,0]];
    const visitado = new Set();
    while(fila.length){
        const[node,profundidade] = fila.shift();
        if(visitado.has(node)) continue
        visitado.add(node);

        if(!niveis[profundidade])  niveis[profundidade]=[];
        niveis[profundidade].push(node);
        for(const c of (filhos[node]|| [])){
            fila.push([c,profundidade+1]);
        }


    }

}
bfs();
const espVertical=80;
const espHorizontal = 100;
for(const profundidade in niveis){
    const nodes = niveis[profundidade];
    nodes.forEach((n,i)=>{
        pos[n]={x:100+i*espHorizontal,y:50+profundidade*espVertical}
    });
}
ctx.strokeStyle ="black";
for(const [p,f] of pares){
    if(p===null) continue;
    if(pos[p] && pos[f]){
        ctx.beginPath()
        ctx.moveTo(pos[p].x, pos[p].y);
        ctx.lineTo(pos[f].x, pos[f].y);
        ctx.stroke();
    }
}
for(const n in pos){
    const {x,y} = pos[n];
    ctx.beginPath();

    ctx.arc(x,y,20,0,Math.PI*2);
    ctx.stroke();

    ctx.fillText(n,x-5,y+5);
}