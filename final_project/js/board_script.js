var source = new EventSource('update_board.php');

$(document).ready(function()
{
  var move = 0;
  
  // Any click on a square
  $("div.square").click(function()
  {
    // Find the player who should move next
    var nextPlayer = (getMark(move) == "X") ? 
                     ($("#player_x_name").text()) : 
                     ($("#player_o_name").text());
    
    // If the square is empty and the current user is the one to move next
    if (($(this).text().length == 0) && (getUsername() == nextPlayer))
    {
      // Places the appropriate mark
      $(this).text(getMark(move));  
      
      // Make changes to database
      $.post("make_move.php", {mover: nextPlayer, 
                               square: $(this).attr("id"),
                               mark: (getMark(move) == "X") ? (1) : (-1)}).done(function(data)
        {
          $("body").append(data);
        });
      
      // Check if a player won
      if (checkRows(getMark(move)) || 
          checkColumns(getMark(move)) || 
          checkDiagonals(getMark(move)))
      {
        alert("Player " + getMark(move) + " won!");
        $("div.square").unbind('click');
        highlightWin(getMark(move));
        closeConnection();      
      }
      else if (move >= 8)
      {
        alert("The game is a draw!");
        closeConnection();
      }

      move++;
    }
  });  
  
  // Sets up the EventSource listeners
  if (window.EventSource)
  {
    // If a message was sent, then check if the opposing player has made a move
    source.addEventListener('message', function(e)
    {
      var message = e.data;
      var fields = message.split("; ");
      
      for (var i = 0; i < fields.length; i++)
      {
        var name = fields[i].substring(0, fields[i].indexOf(":"));
        var value = fields[i].substring(fields[i].indexOf(":") + 2, fields[i].length); 
        var mark = (value == 0) ? ("") : ((value == 1) ? ("X") : ("O"));
        
        // Update move
        if ((name == "turn") && (move != value))
        {
          move = value;
          
          if (move > 8)
          {
            alert("The game is a draw!");
            $.post("end_game.php", {xname: $("#player_x_name").text(),  
                                    oname: $("#player_o_name").text(),
                                    winner: " "}).done(function(data)
            {
              $("body").append(data);
              closeConnection();
            });
          }          
        }
        // Update square if the values do not match
        else if ($("#" + name).text() != mark)
        {
          $("#" + name).text(mark);
          
          // Check if a player won
          if (checkRows(getMark(move)) || 
              checkColumns(getMark(move)) || 
              checkDiagonals(getMark(move)))
          {
            alert("Player " + getMark(move) + " won!");
            $("div.square").unbind('click');
            highlightWin(getMark(move));
            $.post("end_game.php", {xname: $("#player_x_name").text(),  
                                    oname: $("#player_o_name").text(),
                                    winner: getMark(move)}).done(function(data)
            {
              $("body").append(data);
              closeConnection();
            });
          }
        }
      }
    });
  }
});

/*
 * Returns the appropriate mark for the current player.
 *
 * Parameters:
 *   move    The integer equal to the current turn number.
 *
 * Returns:
 *   If the turn number if even, returns "X",
 *                      else returns "O".
 *
 */
 
function getMark(move)
{
  return (move % 2 == 0) ? ("X") : ("O");
}

/*
 * Checks the rows of the tic-tac-toe board to see if there are three matching marks in a row.
 *
 * Parameters:
 *   mark    The string equal to the mark to search for.
 *
 * Returns:
 *   A boolean that is true if there was a match, 
 *                     false otherwise.
 *
 */
 
 function checkRows(mark)
 {
   return (($("#square0").text() == mark) && ($("#square1").text() == mark) && ($("#square2").text() == mark)) || 
          (($("#square3").text() == mark) && ($("#square4").text() == mark) && ($("#square5").text() == mark)) || 
          (($("#square6").text() == mark) && ($("#square7").text() == mark) && ($("#square8").text() == mark));
 }
 
 /*
  * Checks the columns of the tic-tac-toe board to see if there are three matching marks in a row.
  *
  * Parameters:
  *   mark    The string equal to the mark to search for.
  *
  * Returns:
  *   A boolean that is true if there was a match, 
  *                     false otherwise.
  *
  */
 
 function checkColumns(mark)
 {
   return (($("#square0").text() == mark) && ($("#square3").text() == mark) && ($("#square6").text() == mark)) || 
          (($("#square1").text() == mark) && ($("#square4").text() == mark) && ($("#square7").text() == mark)) || 
          (($("#square2").text() == mark) && ($("#square5").text() == mark) && ($("#square8").text() == mark));
 }
 
 /*
  * Checks the diagonals of the tic-tac-toe board to see if there are three matching marks in a row.
  *
  * Parameters:
  *   mark    The string equal to the mark to search for.
  *
  * Returns:
  *   A boolean that is true if there was a match, 
  *                     false otherwise.
  *
  */
 
 function checkDiagonals(mark)
 {
   return (($("#square0").text() == mark) && ($("#square4").text() == mark) && ($("#square8").text() == mark)) || 
          (($("#square2").text() == mark) && ($("#square4").text() == mark) && ($("#square6").text() == mark));
 }
 
 /*
  * Highlights the squares involved in a win.
  * 
  * Parameters:
  *   mark    The mark to search for.
  *
  */
  
function highlightWin(mark)
{
  // There is almost certainly a more efficient way of doing this, but Branden is lazy
  if (($("#square0").text() == mark) && ($("#square1").text() == mark) && ($("#square2").text() == mark))
  {
    $("#square0").css("background-color", getWinColor(mark));
    $("#square1").css("background-color", getWinColor(mark));
    $("#square2").css("background-color", getWinColor(mark));
  }  
  if (($("#square3").text() == mark) && ($("#square4").text() == mark) && ($("#square5").text() == mark))
  {
    $("#square3").css("background-color", getWinColor(mark));
    $("#square4").css("background-color", getWinColor(mark));
    $("#square5").css("background-color", getWinColor(mark));
  }  
  if (($("#square6").text() == mark) && ($("#square7").text() == mark) && ($("#square8").text() == mark))
  {
    $("#square6").css("background-color", getWinColor(mark));
    $("#square7").css("background-color", getWinColor(mark));
    $("#square8").css("background-color", getWinColor(mark));
  }
  if (($("#square0").text() == mark) && ($("#square3").text() == mark) && ($("#square6").text() == mark))
  {
    $("#square0").css("background-color", getWinColor(mark));
    $("#square3").css("background-color", getWinColor(mark));
    $("#square6").css("background-color", getWinColor(mark));
  }
  if (($("#square1").text() == mark) && ($("#square4").text() == mark) && ($("#square7").text() == mark))
  {
    $("#square1").css("background-color", getWinColor(mark));
    $("#square4").css("background-color", getWinColor(mark));
    $("#square7").css("background-color", getWinColor(mark));  
  }
  if (($("#square2").text() == mark) && ($("#square5").text() == mark) && ($("#square8").text() == mark))
  {
    $("#square2").css("background-color", getWinColor(mark));
    $("#square5").css("background-color", getWinColor(mark));
    $("#square8").css("background-color", getWinColor(mark));
  }
  if (($("#square0").text() == mark) && ($("#square4").text() == mark) && ($("#square8").text() == mark))
  {
    $("#square0").css("background-color", getWinColor(mark));
    $("#square4").css("background-color", getWinColor(mark));
    $("#square8").css("background-color", getWinColor(mark));
  }
  if (($("#square2").text() == mark) && ($("#square4").text() == mark) && ($("#square6").text() == mark))
  {
    $("#square2").css("background-color", getWinColor(mark));
    $("#square4").css("background-color", getWinColor(mark));
    $("#square6").css("background-color", getWinColor(mark));
  }
}

/*
 * Returns a string containing the color name to use to highlight a winning square.
 * 
 * Parameters:
 *   mark    The mark to get a color for.
 *
 * Returns:
 *   The string "red" if the mark is "X",
 *   the string "blue" if the mark is "O",
 *   an empty string otherwise.
 *
 */
 
function getWinColor(mark)
{
  var color = "";
  
  switch (mark)
  {
    case "X":
      color = "red";
      break;
    case "O":
      color = "blue";
      break;
    default:
      color = "";
      break;
  }
  
  return color;
}

/*
 * Returns the value of the username cookie.
 *
 * Returns:
 *   A string containing the value of the username cookie.
 *   If none, returns "Guest".
 *
 */
 
function getUsername()
{
  var username = "guest";
  var start_index = document.cookie.indexOf("username=");
  
  if (start_index != -1)
  {
    start_index += 9;
    var end_index = document.cookie.indexOf(";", start_index);
    
    if (end_index == -1)
    {
      end_index = document.cookie.length;
    }
    
    username = document.cookie.substring(start_index, end_index);
  }
 
  return username;
}

/*
 * Stops server-side events.
 *
 */

function closeConnection()
{
  source.close();
}