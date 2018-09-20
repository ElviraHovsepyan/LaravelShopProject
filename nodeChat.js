
var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var dateFormat = require('dateformat');

var mysql = require('mysql');
var con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "lshop"
});


app.get('/', function(req, res){
    res.send('<h1>Hello world</h1>');
});

// io.on('connection', function(socket){
//     console.log('a user connected');
//     // socket.on('disconnect', function(){
//     //     console.log('user disconnected');
//     // });
//
//     socket.userName = '';
//     socket.message = '';
//
//     socket.on('new_message',(data)=>{
//         socket.userName = data.userName;
//         socket.message = data.message;
//         io.sockets.emit('add_message',{message:socket.message,userName:socket.userName});
//     });
// });

io.sockets.on('connection', function (socket) {
    socket.on('room', function(room) {
        socket.join(room);
        socket.on('new_message', function (data) {
            socket.userName = data.userName;
            socket.message = data.message;
            socket.userId = data.userId;
            if(room == 1){
                io.sockets.in(data.receiverId).emit('add_message',{message:socket.message,userName:socket.userName,userId:socket.userId});
            }
            else {
                io.sockets.in(1).emit('add_message',{message:socket.message,userName:socket.userName,userId:socket.userId});
            }
            insertInto(data.userId,data.receiverId,data.message);
        });
    });
});

con.connect(function(err) {
    if (err) throw err;
    console.log("Connected!");
});

function insertInto(userId,receiverId,message){
    var now = new Date();
    now = dateFormat(now, "yyyy-mm-dd hh:MM:ss");
    var sql = "INSERT INTO messages (user_id, sender_id, message, created_at) VALUES ('"+userId+"','"+receiverId+"','"+message+"','"+now+"')";
    con.query(sql, function (err, result) {
        if (err) throw err;
        console.log("1 record inserted");
    });
}

http.listen(3000, function(){
    console.log('listening on *:3000');
});
