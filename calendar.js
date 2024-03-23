
window.onload = function() {
    var currentAction = window.location.search;
    if (currentAction.indexOf('action=calendar') === -1 &&
        currentAction.indexOf('action=today') === -1 &&
        currentAction.indexOf('action=all') === -1) {
        window.location.href = '?action=calendar';
    }
};

function openNav() {
  document.getElementById("main").style.marginLeft = "25%";
  document.getElementById("mySidebar").style.width = "25%";
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("openNav").style.display = 'none';
}

function closeNav() {
  document.getElementById("main").style.marginLeft = "0%";
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("openNav").style.display = "inline-block";
}
