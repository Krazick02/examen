<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>canvas</title>
</head>
<style>
    canvas {
        background-color: orange   ;   
    }
</style>
<body onload="relog()">
    <canvas id="mycanvas" width="1000" height="800"></canvas>  

    <script type ="text/javascript">
        var cv  =null;
        var ctx  = null;
        var superX=240,superY=240;
        var player=null;
        var hormiguero=null;
        var cronometro;
        var obs1=null;
        var obs2=null;
        var obs3=null;
        var obs4=null;
        var obs5=null;
        var min=0;
        var seg=0;
        var direction='left';
        var pause=false;
        var speed=3;           
        var fin= new Image();
        var hUP= new Image();
        var hLEFT= new Image();
        var hDOWN= new Image();
        var hRIGHT= new Image();
        var wall= new Image();
        var crack= new Audio();
        var choque= new Audio();

        
        function start(){
             cv  =document.getElementById('mycanvas');
             ctx  = cv.getContext('2d');
             ctx.strokeRect(0,0,1000,1000);
            player =new Cuadraro(superX,superY,40,40,'blue');
            hormiguero =new Cuadraro(960,760,40,40,'red');
            obs1 =new Cuadraro(150,100,200,20,'black');
            obs2 =new Cuadraro(150,350,200,20,'black');
            obs3 =new Cuadraro(150,600,200,20,'black');
            obs4 =new Cuadraro(750,160,20,440,'black');
            obs5 =new Cuadraro(600,160,20,440,'black');
            hUP.src='hUP.jpeg';
            hDOWN.src='hDOWN.jpeg';
            hRIGHT.src='hRIGTH.jpeg';
            hLEFT.src='hLEFT.jpeg';
            fin.src='fin.jpeg';
            wall.src='wall.png';
            crack.src='hueso_3.mp3';
            choque.src='choque.mp3';
            paint();
        }
        function paint(){
            window.requestAnimationFrame(paint);
            ctx.fillStyle ='black';
            ctx.fillRect(0,0,1000,800);
            ctx.font="30px arial";
            ctx.fillStyle="white";                
            ctx.fillText("TIME : "+min+":"+seg,30,60);
            
            //player.dibujar(ctx);
            
            //hormiguero.dibujar(ctx);

            obs1.dibujar(ctx);           
            obs2.dibujar(ctx);           
            obs3.dibujar(ctx);           
            obs4.dibujar(ctx);
            obs5.dibujar(ctx);
            ctx.drawImage(wall,obs1.x,obs1.y,200,20);
            ctx.drawImage(wall,obs2.x,obs2.y,200,20);
            ctx.drawImage(wall,obs3.x,obs3.y,200,20);
            ctx.drawImage(wall,obs4.x,obs4.y,20,440);
            ctx.drawImage(wall,obs5.x,obs5.y,20,440);


            ctx.drawImage(fin,hormiguero.x,hormiguero.y,40,40);
            ctx.drawImage(hLEFT,player.x,player.y,40,40);
            
            if(direction=='rigth'){
                ctx.drawImage(hRIGHT,player.x,player.y,40,40);
            }
            if(direction=='down'){
                ctx.drawImage(hDOWN,player.x,player.y,40,40);
            }
            if(direction=='up'){
                ctx.drawImage(hUP,player.x,player.y,40,40);
            }
            if(direction=='left'){
                ctx.drawImage(hLEFT,player.x,player.y,40,40);
            }


            if(pause){
                ctx.fillStyle="rgba(0,0,0,0.5)";                
                ctx.fillRect(0,0,1000,800);
                ctx.fillStyle="WHITE";
                ctx.font="50px arial";             
                ctx.fillText("P A U S E",400,380);
            }else{
                update();
            }
        }
        function update(){
            if(direction=='rigth'){
                player.x +=speed;
                if(player.x >= 980){
                    player.x = 0;
                }
            }
            if(direction=='down'){
                player.y +=speed;
                if(player.y >= 780){
                    player.y = 0;
                }
            }
            if(direction=='up'){
                player.y -=speed;
                if(player.y <= 0){
                    player.y = 780;
                }
            }
            if(direction=='left'){
                player.x -=speed;
                if(player.x <= 0){
                    player.x = 980;
                }
            }
            if(player.se_tocan(hormiguero)){
                clearInterval(cronometro);
                speed=0;
                ctx.fillStyle="rgba(0,0,0,0.5)";                
                ctx.fillRect(0,0,1000,800);
                ctx.fillStyle="WHITE";
                ctx.font="50px arial";             
                ctx.fillText("Y O U  W I N",400,380);
                ctx.font="30px arial";             
                ctx.fillText("YOUR TIME WAS = "+min+" min "+seg+ "segs",300,450);
                crack.play();
            }
            if(player.se_tocan(obs1) || player.se_tocan(obs2) || player.se_tocan(obs3) || player.se_tocan(obs4) || player.se_tocan(obs5)){
                if(direction=='rigth'){
                    player.x -=speed;
                    if(player.x >= 980){
                        player.x = 0;
                    }
                }
                if(direction=='down'){
                    player.y -=speed;
                    if(player.y >= 780){
                        player.y = 0;
                    }
                }
                if(direction=='up'){
                    player.y +=speed;
                    if(player.y <= 0){
                        player.y = 780;
                    }
                }
                if(direction=='left'){
                    player.x +=speed;
                    if(player.x <= 0){
                        player.x = 980;
                    }
                }
            }

        }
        function Cuadraro(x,y,w,h,c){
            this.x = x;
            this.y = y;
            this.w = w;
            this.h = h;
            this.c = c;
            this.se_tocan = function (target) { 
                if(this.x < target.x + target.w &&
                this.x + this.w > target.x && 
                this.y < target.y + target.h && 
                this.y + this.h > target.y){
                    return true; 
                }  
            };
            this.dibujar = function(ctx){
                ctx.fillStyle=this.c;
                ctx.fillRect(this.x,this.y,this.w,this.h);
                ctx.strokeRect(this.x,this.y,this.w,this.h);
            }
        }
        document.addEventListener('keydown',function(e){
        if(e.keyCode == 87 || e.keyCode == 38){
            direction='up';
        }
        //ritgh
        if(e.keyCode == 83 || e.keyCode == 40){
            direction='down';
        }
        //left
        if(e.keyCode == 65 || e.keyCode == 37){
            direction='left';
        }
        //down
        if(e.keyCode == 68 || e.keyCode == 39){
            direction='rigth';
        }
        //down
        if(e.keyCode == 32){
            pause=(pause)?false:true;
        }
        //RESTART
        if(e.keyCode == 114 || e.keyCode == 82 ){
            location.reload();
        }
        })
        function generateRandomInteger(max) {
            return Math.floor(Math.random() * max) + 1;
        }
        window.addEventListener('load',start)
        window.requestAnimationFrame = (function () {
            return window.requestAnimationFrame ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame ||
                function (callback) {
                    window.setTimeout(callback, 17);
                };
        }());
        function rbgaRand() {
            var o = Math.round, r = Math.random, s = 255;
            return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
        }

        function relog(){
            cronometro=setInterval(function(){
                if(seg==60){
                    seg=0;
                    min+=1;
                    if(min==60){
                        min=0;
                    }
                }
                seg++;
            },1000);
        }
        
    </script>
</body> 
</html>