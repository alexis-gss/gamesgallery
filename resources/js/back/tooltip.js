window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js');

document.addEventListener("DOMContentLoaded", function(){
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(element){
        return new bootstrap.Tooltip(element, {'delay': { show: 800 }});
    });
});