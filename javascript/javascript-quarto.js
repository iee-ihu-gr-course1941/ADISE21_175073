// var me = { username: null, player_id: null, token: null, role: null };
// var game_status = { status: null, p_turn: null, current_piece: null, result: null, win_direction: null, last_change: null };
// var last_update = new Date().getTime();
// var timer = null;


$(function() {
    empty_board();
});

function login_to_game() {
    if (isset($_POST['login-submit'])) {
        if ((empty($('#username').val())) || (empty(('#pwd').val()))) {
            alert('You have to set a values');
            return;
        } else {
            $sql = "SELECT * FROM users where uidUsers=? OR emailUsers=?;";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../index.php?error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
                mysqli_stmt_execute($stmt);
                $results = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($results)) {
                    $pwdCheck = password_verify($password, $row['pwdUsers']);
                    if ($pwdCheck == false) {
                        header("Location: ../index.php?error=wrongpwd");
                        exit();
                    } else if ($pwdCheck == true) {
                        session_start();
                        $_SESSION['userId'] = $row['idUsers'];
                        $_SESSION['userUid'] = $row['uidUsers'];

                        header("Location: ../index.php?login=success");
                        exit();
                    } else {
                        header("Location: ../index.php?error=wrongpwd");
                        exit();
                    }
                } else {
                    header("Location: ../index.php?error=noUser");
                    exit();
                }
            }
        }
    } else {
        header("Location: ../index.php");
        exit();
    }
    draw_empty_board();
    $.ajax({
        url: "api/v1/index.php/lib/login/",
        method: 'PUT',
        dataType: "json",
        headers: { "X-Token": $_COOKIE['tokenC'] },
        contentType: 'application/json',
        data: JSON.stringify({ username: $('#username').val() }),
        success: login_result,
        error: login_error
    });

}

function empty_board() {
    var table = '<table id = "quarto-table">';
    for (var i = 1; i <= 4; i++) {
        table += '<tr>';
        for (var j = 1; j <= 4; j++) {
            table += '<td class = "quarto-sq" id = "sq_' + i + '_' + j + '"> <img class = "piece" src = "images/p.png"><br>' + i + ',' + j + ' </img></td>';
        }
        table += '</tr>';
    }
    table += '</table>'
    $('#quarto-board').html(table);
}


function available_piece() {
    var table = '<table id = "available-piece">';
    for (var i = 1; i <= 2; i++) {
        table += '<tr>';
        for (var j = 1; j <= 8; j++) {
            table += '<td class = "quarto-sq" id = "pi_' + i + '_' + j + '"> <img class = "piece' + i + ' ' + j + '" src = "images/p' + i + '-' + j + '.png"><br>' + i + ',' + j + ' </img></td>';
        }
        table += '</tr>';
    }
    table += '</table>'
    $('#available-piece').html(table);
}

function login_result(data) {
    if (isset($_POST['login-submit'])) {
        // me = data[0]; ?
        $("#game_login_input").hide();
        piece_list();
        update_info();
        game_status_update();
    }
}

// function login_error(data) {
// 	var x = data.responseJSON;
// 	alert(x.errormesg);
// }

function update_info() {
    $('#player_info').html("<h4>Player info</h4> " +
        "<strong> Username:</strong>" + me.username +
        "<strong> id: </strong>" + me.player_id +
        "<strong> token: </strong>" + me.$_COOKIE['tokenC'] +
        "<strong> Player role: </strong> " + me.role +
        "<br><h4>Game info</h4>" +
        "<strong> Game state: </strong>" + game_status.status +
        "<strong> Player turn: </strong>" + game_status.turn +
        "<strong> Current Piece: </strong>" + game_status.current_piece +
        "<strong> Result: </strong>" + game_status.result);
}