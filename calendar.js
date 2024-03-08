
window.onload = function() {
    var currentAction = window.location.search;
    if (currentAction.indexOf('action=calendar') === -1 &&
        currentAction.indexOf('action=today') === -1 &&
        currentAction.indexOf('action=all') === -1) {
        window.location.href = '?action=calendar';
    }
};