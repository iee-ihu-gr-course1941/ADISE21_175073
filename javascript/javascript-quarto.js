var me = { username: null, player_id: null, token: null, role: null };
var game_status = { status: null, p_turn: null, current_piece: null, result: null, win_direction: null, last_change: null };
var last_update = new Date().getTime();
var timer = null;


$(function () {
    empty_board();
});

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


