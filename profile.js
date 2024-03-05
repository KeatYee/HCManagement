// Show the edit form pop-up according input
function openEditForm(formId) {
    var editFormContainer = document.getElementById(formId);
    editFormContainer.style.display = "block";
}

// Close button click event listener
function closeEditForm(formId) {
    var editFormContainer = document.getElementById(formId);
    editFormContainer.style.display = "none";
}


 // Logout button click event listener
document.getElementById("logoutButton").addEventListener("click", function() {
    window.location.href = "logout.php";
    
});

    // Delete button click event listener
document.getElementById("deleteButton").addEventListener("click", function() {
   if (confirm("Are you sure you want to delete your account?")) {
        window.location.href = "deleteAcc.php";
    }
});

window.onload = function() {
    var currentAction = window.location.search;
    if (currentAction.indexOf('action=acc') === -1 &&
        currentAction.indexOf('action=med') === -1 &&
        currentAction.indexOf('action=today') === -1) {
        window.location.href = '?action=acc';
    }
};


