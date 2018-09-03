
var h = 0;
$('.chatHead').click(function () {
    if(h==0){
        $('.chatDiv').animate({'height':'60px'},1000);
        $('.chatDiv form').hide();
        h=1;
    } else {
        $('.chatDiv').animate({'height':'360px'},1000);
        $('.chatDiv form').show(1000);
        h=0;
    }
});

var socket = io.connect('http://localhost:3000/');
var userName = $('.usname').text();
var userId = $(".usname").attr("usId");
var receiverId;

socket.on('connect', function() {
    socket.emit('room', userId);
});

$(document).ready(function () {
    $.ajax({
        url: '/chat',
        type: 'post',
        data: {userId:userId}
    }).done(function (response) {
        var user = JSON.parse(response);
        var author;
        if(userId==1){
            for(var i = 0; i<user.length; i++){
                author = user[i]['user']['name'];
                $('.chatBody').append('<p><input class="checkUser" type="checkbox" usId="'+user[i]['user_id']+'">'+author+' : '+user[i]['message']+'</p>');
            }
        } else {
            for(var i = 0; i<user.length; i++){
                if(user[i]['user_id'] == userId){
                    author = userName;
                } else {
                    author = 'Support';
                }
                $('.chatBody').append('<p>'+author+' : '+user[i]['message']+'</p>');
            }
            $('.chatBody').scrollTop(300000000);
        }
        addChangeListener();
    });
});

$('.sendButton').click(function (e) {
    e.preventDefault();
    useSocket();
});
$('#message').keypress(function (e) {
    if(e.keyCode==13){
        e.preventDefault();
        useSocket();
        sendMessageToMe();
    }
});

function sendMessageToMe(){
    var message = ($('#message').val()).trim();
    if(userId==1){
        $('.chatBody').append('<p><input class="checkUser" type="checkbox" usId="'+userId+'">'+userName+' : '+message+'</p>');
    } else {
        $('.chatBody').append('<p>'+userName+' : '+message+'</p>');
    }
    $('#message').val('');
}

function useSocket() {
    var message = ($('#message').val()).trim();
    socket.emit('new_message',{message:message,userName:userName,userId:userId,receiverId:receiverId});
    $('.chatBody').scrollTop(300000000);
}

function addChangeListener(){
    $('.checkUser').off('change');
    $('.checkUser').on('change',function () {
        $('.checkUser').each(function () {
            if($(this).prop('checked')==true){
                receiverId = $(this).attr('usId');
            }
        });
    });
}

socket.on('add_message',(data)=>{
    console.log(data);
    if(userId==1){
        $('.chatBody').append('<p><input class="checkUser" type="checkbox" usId="'+data.userId+'">'+data.userName+' : '+data.message+'</p>');
    } else {
        $('.chatBody').append('<p>'+data.userName+' : '+data.message+'</p>');
    }
    addChangeListener();
    $('#message').val('');
});
