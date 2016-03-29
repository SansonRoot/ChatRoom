/**
 * Created by SANSON ROOT on 3/26/2016.
 */


var r1 = '<div class="direct-chat-msg"> \
    <div class="direct-chat-info clearfix"> \
    <span class="direct-chat-name pull-left">';
var r2 = '</span> \
    <span class="direct-chat-timestamp pull-right">';
var r3 = '</span> \
    </div> \
    <img class="direct-chat-img" src="img/profile.png" \
    alt="message user image"> <div class="direct-chat-text">';
var r4 = '</div></div>';


var s1 = '<div class="direct-chat-msg right"> \
    <div class="direct-chat-info clearfix"> \
    <span class="direct-chat-name pull-right">';
var s2 = '</span> \
    <span class="direct-chat-timestamp pull-left">';
var s3 = '</span> \
    </div> \
    <img class="direct-chat-img" src="img/anonymous.jpg" \
    alt="message user image"> <div class="direct-chat-text">';

var s4 = '</div></div>';


var myname = document.getElementById("myname");
var list = document.getElementById("list");
var msg = document.getElementById("message");
var chatwindow = document.getElementById("chatWindow");
var connectionState = document.getElementById("conn");
var online = document.getElementById("connected_count");
var typing = document.getElementById("state");
var open = false;


var socket = new WebSocket('ws://192.168.48.10:2000');


var currentTime = new Date();
var gettime = currentTime.getHours() + ":" + currentTime.getMinutes() + ":" + currentTime.getSeconds();
var datetime = currentTime.toDateString() + " " + gettime;
var total = 0;

function updatelist(listarr) {
    for (var i = 0; i < listarr.length; i++) {
        list.innerHTML += '<li>' + listarr[i] + '</li>';
    }

}
function setConnected(val) {
    var str = "";
    if (val == 1) {
        str = 'Person';
    } else {
        str = 'People';
    }
    online.innerHTML = '<b>' + val + ' ' + str + ' Online <i class="glyphicon glyphicon-circle-arrow-left"></i> </b>';
}
function addSenderMsg(msg) {
    chatwindow.innerHTML += s1 + myname.value + s2 + datetime + s3 + msg;
    chatwindow.scrollTop = chatwindow.scrollHeight;
}
function addReceiverMsg(msg, name) {
    chatwindow.innerHTML += r1 + name + r2 + datetime + r3 + msg;
    chatwindow.scrollTop = chatwindow.scrollHeight;
}
function setTypingMsg(name) {
    if (name == "") {
        typing.innerHTML = "";
    } else {
        typing.innerHTML = '<b>' + name + ' is typing ...</b>';
    }
}

function addConMsg(msg) {

    connectionState.innerHTML = '<strong>' + msg + '</strong>';
}

msg.addEventListener('keypress', function (evt) {

    if (evt.keyCode != 13) {

        socket.send(JSON.stringify({
                action: 'typing',
                name: myname.value
            }
        ));

    } else {
        evt.preventDefault();

        if (msg.value == "") {
            return;
        }

        socket.send(JSON.stringify({
                msg: msg.value,
                action: 'message',
                name: myname.value
            }
        ));

        addSenderMsg(msg.value);
        setTypingMsg("");
        msg.value = "";
    }


});


socket.onopen = function (evt) {
    open = true;
    addConMsg("Connected !");

};
socket.onclose = function (evt) {
    open = false;
    addConMsg("Disconnected !");
};

socket.onmessage = function (evt) {
    var data = JSON.parse(evt.data);

    if (data.action == 'online') {
        setConnected(data.number);
        //updatelist(data.list);
    } else if (data.action == 'typing') {
        setTypingMsg(data.name);
    } else if (data.action == 'message' && data.msg !== "") {
        addReceiverMsg(data.msg, data.name);
        setTypingMsg("");
    }


};





