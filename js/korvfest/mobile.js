// game
var canvas = null;
var ctx = null;
var item = {x: Math.floor(window.innerWidth * .5), vx: 0, y: Math.floor(window.innerHeight + 100), vy: 0};
var control = {x: Math.floor(window.innerWidth * .5), y: Math.floor(window.innerHeight * .5)};
var isControlActive = true;
var currentPosition = 0;
var sausage = new Image();
    sausage.src = "image/mobile/game/blyant-large.png";

// login
var playerId = -1;
var playerName = null;
var gameId = -1;

// pages
var pages = null;

// utils
var ajaxHeaders = {"cache-control": "no-cache"};

$(document).ready(function() {
    
    // pages
    
    pages = [$("#loading"), $("#welcome"), $("#login"), $("#game"), $("#game-over"), $("#highscore")];
    
    changePage("loading");
    
    // welcome
    
    $("#welcome > #play-button").click(function(event) {
        
        event.preventDefault();
        
        changePage("login");
    });
    
    $("#welcome > #highscore-button").click(function(event) {
        
        event.preventDefault();
        
        changePage("highscore");
    });
    
    // login
    
    $("#login > #submit-button").click(function(event) {
        
        event.preventDefault();
        
        if ($("#username-input").val() != "") {
        
            changePage("loading");

            $.ajax({
                url: "service/login.php",
                type: "POST",
                dataType: "json",
                data: {
                    playerId: playerId,
                    username: $("#username-input").val()
                },
                headers: ajaxHeaders,
                success: onLoginSuccessHandler
            });
        }
    });
    
    $("#login > #facebook-connect-button").click(function(event) {
        
        event.preventDefault();
                
        changePage("loading");
        
        FB.login(function(loginResponse) {
            
            if (loginResponse.authResponse) {
                
                FB.api("/me", function(userResponse) {
                    
                    // response.first_name
                    
                    $.ajax({
                        url: "service/login.php",
                        type: "POST",
                        dataType: "json",
                        data: {
                            facebookId: loginResponse.authResponse["userID"],
                            username: userResponse.first_name
                        },
                        headers: ajaxHeaders,
                        success: onLoginSuccessHandler
                    });
                });                
            } else {
                // could not connect
            }
        });
    });
    
    // canvas
    
    canvas = $("#gameCanvas")[0];
    ctx = canvas.getContext("2d");
    
    /*
    
    // accelerometer
    
    var accelerometer = {x: 0, y: 0, z: 0};
    
    $(window).bind("devicemotion", function(event) {
        
        var a = event.originalEvent.accelerationIncludingGravity;
        
        accelerometer.x = a.x;
        accelerometer.y = a.y;
        accelerometer.z = a.z;
    });

    */
    
    // touch
    
	canvas.addEventListener("touchstart", function(event) {
        
        event.preventDefault();        
    });
    
    canvas.addEventListener("touchmove", function(event) {
        
        event.preventDefault();
        
        var touch = getTouch(event);
        
        control.x = touch.x;
        control.y = touch.y;        
    });
    
	canvas.addEventListener("touchend", function(event) {
        
        event.preventDefault();
        
        var releaseArea = (window.innerHeight * .3);
        
        if (isControlActive == true && control.y > (window.innerHeight - releaseArea)) {
            
            isControlActive = false;
            
            var power = 1 - (window.innerHeight - control.y) / releaseArea;
            var offset = (window.innerWidth - control.x) / window.innerWidth;
			
			// send data
            $.ajax({
                url: "service/shoot.php",
                type: "POST",
                dataType: "json",
                data: {
                    power: power,
                    offset: offset,
                    playerId: playerId,
                    gameId: gameId
                },
                headers: ajaxHeaders,
                success: function(data) {
                    
                    if (data["game_over"] == true) {
                        
                        $("#game-over > #success").css("display", "none");
                        $("#game-over > #failed").css("display", "none");
                        
                        $.ajax({
                            url: "service/game.php",
                            type: "GET",
                            dataType: "json",
                            data: {
                                gameId: gameId
                            },
                            headers: ajaxHeaders,
                            success: function(data) {
                                
                                if (data) {
                                    
                                    $("#game-over > #success > #score > span").text(data["total_score"] + "p");
                                    $("#game-over > #success > #position > span").text(data["position"]);
                                    $("#game-over > #success").css("display", "block");
                                } else {
                                    
                                    $("#game-over > #failed").css("display", "block");
                                }
                            }
                        });
                        
                        changePage("game-over");                        
                    }
                    
                    /*
                    // update score
                    $("#game > #score").text(data["score"] + "p");
                    $("#game > #score").css("opacity", 0);
                    TweenMax.killDelayedCallsTo($("#game > #score"));
                    TweenMax.to($("#game > #score"), 1, {css: {opacity: 1}, delay: 1, yoyo: true, repeat: 1});
                    */
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("error: " + XMLHttpRequest.responseText);
                }
            });
            
            // animate
            TweenMax.to(item, .25 + (.5 * (1 - power)), {
                x: Math.floor(window.innerWidth * .5),
                y: -150,
                ease: Strong.easeOut,
                onComplete: function() {
                    
                    setTimeout(function() {
                        
                        item.x = Math.floor(window.innerWidth * .5);
                        item.y = Math.floor(window.innerHeight) + 100;
                        
                        control.x = Math.floor(window.innerWidth * .5);
                        control.y = Math.floor(window.innerHeight * .5);
                        
                        isControlActive = true;
                    
                    }, 1000);
                }
            });
            
        } else {
            control.x = Math.floor(window.innerWidth * .5);
            control.y = Math.floor(window.innerHeight * .5);
        }        
    });
    
    // game-over
    
    $("#game-over > #replay-button").click(function(event) {
        
        event.preventDefault();
    
        changePage("loading");

        $.ajax({
            url: "service/login.php",
            type: "POST",
            dataType: "json",
            data: {
                playerId: playerId
            },
            headers: ajaxHeaders,
            success: onLoginSuccessHandler
        });
    });
    
    $("#game-over > #facebook-share-button").click(function(event) {
        
        event.preventDefault();
        
        FB.ui({
            method: "feed",
            redirect_uri: "http://korvfest.good-morning.no",
            link: "http://korvfest.good-morning.no",
            picture: "http://korvfest.good-morning.no/image/social/fb_200.png",
            name: "Korvfest",
            caption: "http://korvfest.good-morning.no",
            description: "Jag har precis spelat Korvfest spelet. Pröva du med!"
        }, function (response) {
            // alert("post shared");
        });
        
    });
    
    $("#game-over > #back-button").click(function(event) {
        
        event.preventDefault();
        
        changePage("welcome");
    });
    
    $("#game-over > #highscore-button").click(function(event) {
        
        event.preventDefault();
        
        changePage("highscore");
    });
        
    
    // highscore
    
    $("#highscore > #back-button").click(function(event) {
        
        event.preventDefault();
        
        changePage("welcome");
    });
    
});

function changePage(_pageId) {
    
    for (var i = 0; i<pages.length; i++) {
        
        if (pages[i].attr("id") == _pageId) {
            
            pages[i].css("display", "block");
        } else {
            
            pages[i].css("display", "none");
        }
    }
    
    // specific
    
    switch (_pageId) {
        
        case "login":
            stopGame();
            break;
            
        case "game":
            resetGame();
            startGame();
            break;
            
        case "loading":
            stopGame();
            break;
            
        case "game-over":
            stopGame();
            break;
            
        case "highscore":
            updateHighscore();
            break;
    }
}

function onLoginSuccessHandler(data) {
        
    playerId = data["player_id"];
    gameId = data["game_id"];
    
    changePage("game");
}

function resetGame() {
    
    isControlActive = true;
}

function startGame() {

    TweenMax.ticker.addEventListener("tick", renderGame);
}

function stopGame() {
    
    TweenMax.ticker.removeEventListener("tick", renderGame);
}

function renderGame() {
    
    // resize canvas
    ctx.canvas.width = window.innerWidth;
    ctx.canvas.height = window.innerHeight;
    
    // clear canvas
    ctx.clearRect(0, 0, window.innerWidth, window.innerHeight);
    
    if (isControlActive) {
        
        // move item
        item.vx += (control.x - item.x) * .1;
        item.vy += (control.y - item.y) * .1;
        
        item.x += (item.vx *= .9);
        item.y += (item.vy *= .9);
    }
    
    // draw image
    ctx.drawImage(sausage, (item.x - 300), (item.y - 100), 642, 236); 
}

function getTouch(event) {
    
    return {x: event.touches[0].pageX, y: event.touches[0].pageY};
}

function updateHighscore() {
    
    $("#highscore > ol").css("display", "none");
    $("#highscore > #loading").css("display", "block");
    
    $.ajax({
        url: "service/highscore.php",
        type: "POST",
        dataType: "json",
        headers: ajaxHeaders,
        success: onUpdateHighscoreSuccessHandler
    });
}

function onUpdateHighscoreSuccessHandler(data) {
    
    // todo: check if there are no highscores and display text instead
    
    if (data.highscore.length > 0) {
        
        $("#highscore > ol > li").each(function(i) {
            
            var item = $(this);
            
            if (data.highscore[i] != undefined) {
                
                item.css("display", "block");
                item.find(".name").text(data.highscore[i].username);
                item.find(".score").text(data.highscore[i].total_score + "p");
            } else {
                
                item.css("display", "none");
            }
        });
    
        $("#highscore > ol").css("display", "block");
    } else {
        
        $("#highscore > #fallback").css("display", "block");
    }
    
    $("#highscore > #loading").css("display", "none");
}