var bodyParser = require("body-parser");
let express = require("express");
let app = express();
let server = require("http").Server(app);
let io = require("socket.io")(server);
let stream = require("./ws/stream");
let path = require("path");
let favicon = require("serve-favicon");

app.use(favicon(path.join(__dirname, "pngguru.com.ico")));
app.use("/assets", express.static(path.join(__dirname, "assets")));

app.use(express.static(__dirname + "/"));
app.use(bodyParser.urlencoded({
    extended: false
}));
app.engine("html", require("ejs").renderFile);

// app.set("views", path.join(__dirname, "views"));
// app.set("view engine", "html");
// app.set("views", __dirname);

app.engine("html", require("ejs").renderFile);
app.set("view engine", "html");
app.set("views", __dirname);


// app.get("/:session/:name", (req, res) => {
//     // res.sendFile(__dirname + "/index.html");
//     var session = req.params.session;
//     var user = req.params.name;
//     // console.log('session: ' + session + '/user: ' + user);
//     res.render("index", {
//         session: session,
//         user: user
//     });
// });

app.get("/video/:session", (req, res) => {
    var session = req.params.session;
    res.render("video", {
        session: session,
    });
})

io.of("/stream").on("connection", stream);

var port = process.env.PORT || 6999;

const users = {};

io.on("connection", socket => {
    socket.on("chatMessage", data => {
        if (typeof data[1] === 'string') {
            console.log('CHAT: image => user[' + data[0]["name"] + "] session[" + data[2] + "] file[" + data[1] + "] id[" + data[4] + "]");
            io.emit("chatMessage_image", {
                user: data[0],
                message: data[1],
                session: data[2],
                unread: data[3],
                message_id: data[4]
            });
        } else if (data[1] && typeof data[1] === 'object') {
            if (data[1][1] == 'time') {
                console.log('CHAT: video time => user[' + data[0]["name"] + "] session[" + data[2] + "] time[" + data[1][0] + "]");
                io.emit("chatMessage_time", {
                    user: data[0],
                    message: data[1][0],
                    session: data[2],
                    type: 'video_time'
                    // unread: data[3],
                    // message_id: data[4]
                });
            } else {
                console.log('CHAT: message => user[' + data[0]["name"] + "] session[" + data[2] + "] text[" + data[1]['message'] + "] id[" + data[4] + "]");
                io.emit("chatMessage", {
                    user: data[0],
                    message: data[1],
                    session: data[2],
                    unread: data[3],
                    message_id: data[4]
                });
            }
        }
    });

    // -------------------------------------------------userOnline
    socket.on("login", data => {
        if (data.userId) {
            console.log("a user " + data.userId + " connected");
            io.emit("userOnline", {
                userId: data.userId
            });
            users[socket.id] = data.userId;
        }
    });
    socket.on("disconnect", (reason) => {
        if (users[socket.id] && reason != 'ping timeout') {
            console.log("user " + users[socket.id] + " disconnected" + reason);
            io.emit("userOffline", {
                userId: users[socket.id]
            });
            delete users[socket.id];
        }
    });

    // -------------------------------------------------toChat
    socket.on("toChat", data => {
        io.emit("toChat", {
            session: data[0],
            user_id: data[1]
        });
    });

    // -------------------------------------------------roomVideo
    socket.on("roomVideo", data => {
        console.log("roomVideo: ", data);
        io.emit("roomVideo", {
            data: data
        });
    });

    // -------------------------------------------------roomLink
    socket.on("nameRoom", data => {
        console.log("Room created: ", data);
        io.emit("nameRoom", {
            data: data
        });
    });

    // -------------------------------------------------roomAnswer
    socket.on("roomAnswer", data => {
        console.log("roomAnswer: ", data);
        io.emit("roomAnswer", {
            data: data
        });
    });

    // -------------------------------------------------cancelCall
    socket.on("cancelCall", data => {
        console.log('cancelCall: ', data);
        io.emit("cancelCall", {
            data: data
        });
    });

    // -------------------------------------------------typing
    socket.on("typing", data => {
        // console.log('typing: ', data);
        io.emit("typing", {
            session: data[0],
            user_id: data[1]
        });
    });

    // -------------------------------------------------stopTyping
    socket.on("stopTyping", (data) => {
        // console.log('stopTyping: ', data);
        io.emit("stopTyping", {
            session: data[0],
            user_id: data[1]
        });
    });

    // -------------------------------------------------videoTime
    socket.on("videoTime", (data) => {
        console.log('videoTime: ', data);
        io.emit("videoTime", {
            session: data[0],
            time: data[1],
            status: data[2],
            user_id: data[3]
        });
    });

});

server.listen(port, () => {
    console.log("Run Port // :", port);
});
