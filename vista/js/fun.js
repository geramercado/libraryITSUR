document.addEventListener('DOMContentLoaded',function(){
    document.getElementById('select').addEventListener('change',function(){
        var x = document.getElementById('select').value;
        if(x==0){
            document.getElementById('f1').hidden=true;
            document.getElementById('f2').hidden=true;
            document.getElementById('area').hidden=true;
            document.getElementById('servicio').hidden=true;
        }
        else if(x==1){
            document.getElementById('f1').hidden=false;
            document.getElementById('f2').hidden=false;
            document.getElementById('area').hidden=true;
            document.getElementById('servicio').hidden=true;
        }
        else if(x==2){
            document.getElementById('f1').hidden=true;
            document.getElementById('f2').hidden=true;
            document.getElementById('area').hidden=false;
            document.getElementById('servicio').hidden=true;
        }
        else{
            document.getElementById('f1').hidden=true;
            document.getElementById('f2').hidden=true;
            document.getElementById('area').hidden=true;
            document.getElementById('servicio').hidden=false;
        }
    });
});