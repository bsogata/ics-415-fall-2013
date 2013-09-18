$(document).ready(function()
{
  $(".answer").hide(1);

  $("dt.question").click(function()
  {
    $(this).next().slideToggle("fast", changeMarker(this));
  });
});

/*
 * Changes the mark in front of a question between "+" and "-".
 * 
 * Parameters:
 *   element        The element to alter.
 *
 */

function changeMarker(element)
{
  // If the element is in fact a question
  if (element.getAttribute("class") == "question")
  {
    // If currently "-", change to "+"
    if ($(element).text()[0] == "-")
    {
      $(element).text("+" + $(element).text().substr(1));
    }
    // If currently "+", change to "-"
    else if ($(element).text()[0] == "+")
    {
      $(element).text("-" + $(element).text().substr(1));
    }
  }
}