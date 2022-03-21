function showalert(message,alerttype) {
    let icon;

    switch (alerttype) {
        case "alert-primary": icon = '<i id="alertSymbol" class="fas fa-info-circle"></i>'; break;
        case "alert-warning": icon = '<i id="alertSymbol" class="fas fa-exclamation-triangle"></i>'; break;
        case "alert-danger": icon = '<i id="alertSymbol" class="fas fa-exclamation-circle"></i>'; break;
        case "alert-success": icon = '<i id="alertSymbol" class="fas fa-check-circle"></i>'; break;
    }

    $('#alert_placeholder').append('<div id="alertdiv" class="alert ' +  alerttype + ' alert-dismissible fade show"><span>'+icon+' '+message+'</span> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')

    setTimeout(function() {

        $("#alertdiv").fadeOut();
        location.reload();
    }, 2000);
}

function getCookie(cookieName) {
    let cookie = {};
    document.cookie.split(';').forEach(function(el) {
        let [key,value] = el.split('=');
        cookie[key.trim()] = value;
    })
    return cookie[cookieName];
}

