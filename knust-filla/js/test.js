
var online=document.getElementById("connected_count");

var socket2=new WebSocket('ws://192.168.48.10:2000');

var total=0;

function setConnectedNumber(val){
    online.innerHTML = val + ' People Connected';
}

socket2.onopen= function () {
    open=true;
    total ++;
    socket2.send(total);
};
socket2.onclose=function(){
    open=false;
    total --;
    socket2.send(total);
};

socket2.onmessage=function(evt){
    setConnectedNumber(evt.data);
};

