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

function alert()
{
  alert("password incorrect, please try again!");
}

function checkAdminPW()
{
  alert ("HELLO WORLD");
  if(document.getElementById('passwordHidden').value == document.getElementById('inputAdminPW').value)
  {
    alert ("SUCCESS!!");
  }
}


//funcstion for the admin.php page
function marketPage()
{
  
}