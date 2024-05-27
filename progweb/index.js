function dropDownShow() {
    var dropDown = document.getElementById("myDropdown").classList.toggle("show");
}

function changeSearchBy()
{
    // document.getElementById("searchByVal").innerText=check();
    document.getElementById("dropbtn").innerText=check();
}
function check(){
    var searchBy = document.getElementsByName("searchBy");
    var searchValue="";
    
    for(var search of searchBy){
            if(search.checked){
            searchValue=""+search.value;
        }
    }
return searchValue;
}

window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
} 