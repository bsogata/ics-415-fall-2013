$(document).ready(function()
{
  $("#input").submit(function(event)
  {
    removeResults();
    
    var value = $("#url").val();
    $.get(value, function(data)
                 {
                   alert(data);
                   var retrieved = $("*", $(data));
                   var tagNames = [];
                   var tagCounts = [];
                   
                   for (var i = 0; i < retrieved.length; i++)
                   {
                     var tagName = $(retrieved).get(i).nodeName;
                     alert(tagName);
                     
                     // If the tag does not exist in tagNames, then create a new entry
                     if (tagNames.indexOf(tagName) == -1)
                     {
                       tagNames.push(tagName);
                       tagCounts.push(0);
                     }
                     
                     // Increment the count for tagName
                     tagCounts[tagNames.indexOf(tagName)]++;
                   }
                   
                   // (Re)Creates the table
                   var table = $("<table></table>").attr("id", "part1").attr("border", "1");
                   var tableHeader = $("<thead></thead>");
                   var headerRow = $("<tr></tr>");
                   var tagHeader = $("<th></th>").text("Tag");
                   var countHeader = $("<th></th>").text("Count");
                   headerRow.append(tagHeader, countHeader);
                   tableHeader.append(headerRow);
                   table.append(tableHeader);
                   
                   var tableBody = $("<tbody></tbody>");
                   
                   // Adds each pair of tag names and counts to the table
                   for (var j = 0; j < tagNames.length; j++)
                   {
                     var tagRow = $("<tr></tr>");
                     var nameCell = $("<td></td>").text(tagNames[j]);
                     var countCell = $("<td></td>").text(tagCounts[j]);
                     tagRow.append(nameCell, countCell);
                     tableBody.append(tagRow);
                   }
                   
                   table.append(tableBody);
                   
                   $("#input").append(table);
                   /*
                   var count = $("<p></p>").text("Total tags: " + tagCount);
                   $("#input").append(count);
                   */
                 });
    event.preventDefault();             
  });  
  
  $("#js").click(function()
  {
    removeResults();
    var value = $("#url").val();
    $.get(value, function(data)
                 {
                   var retrieved = $("script", $(data));
                   
                   var scriptList = $("<ul></ul>").attr("id", "part2");
                   
                   for (var i = 0; i < retrieved.length; i++)
                   {
                     // If the script tag includes a src attribute, then it links to an external file
                     if ($(retrieved[i]).attr("src") != null)
                     {
                       var externalScript = $("<li></li>").text($(retrieved[i]).attr("src"));
                       scriptList.append(externalScript);
                     }
                   }
                   
                   $("#input").append(scriptList);
                 });                   
  });
});

/*
 * Removes the results from Parts 1 and 2 from the page.
 */
 
function removeResults()
{
  $("#part1").remove();
  $("#part2").remove();
}