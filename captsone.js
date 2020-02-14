// red/green input texts in HTML
function filterFunction()
{
  var input, filter, ul, li, a, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  div = document.getElementById("myDropdown");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
      } else {
      a[i].style.display = "none";
    }
  }
}

//SEND BACK TO PAGE WITHIN SUBMISSION
document.getElementById("newPatSubmission").onclick = function()
{
  window.location = "index.php";
};
