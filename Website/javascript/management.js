async function manageEvidence(uID,id,type) {

    let formData = {
        uID:uID,
        identity:id,
        username:getCookie("username"),
        typ:type
    };

    let response = await fetch("../accessories/management.php", {
        method: "POST",
        body: JSON.stringify(formData),
        headers : {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    });

    if (response.ok) { // if HTTP-status is 200-299
        // get the response body (the method explained below)
        let json = await response.json();
        switch (json) {
            case "delete":showalert("Az általad kiválasztott bizonyíték törlésre került.","alert-warning"); break;
            case "agree": showalert("Az általad kiválasztott bizonyíték elfogadásra keürlt.","alert-success"); break;
            case "decline": showalert("Az általad kiválasztott bizonyíték elutasításra került.","alert-warning"); break;
       }
    } else {
        showalert("HTTP-Error: " + response.status,"alert-danger");
    }

}


async function sendwarn() {
    let formData = {
        username:document.getElementById("username").value,
        reason:document.getElementById("reason").value,
        date:Date.now(),
        admin:getCookie("username"),
    };

    let response = await fetch("../accessories/management_warn.php", {
        method:"POST",
        body:JSON.stringify(formData),
        headers:{
            'Content-Type':'application/json',
            'Accept':'application/json'
        }
    });

    if (response.ok) {
        let json = await response.json();
        switch (json) {
            case "success":showalert("Sikeresen kiosztottad a figyelmeztetést.","alert-success"); break;
            case "notexist": showalert("Az általad beírt felhasználó nem létezik.","alert-warning"); break;
        }
    } else {
        showalert("HTTP-Error: " + response.status,"alert-danger");
    }
}

function showTable() {

    fetch('../accessories/getWarns.php', {mode:'no-cors'})
        .then(res => res.json())
        .then(x => load(x));
}

function load (jsonData) {
    var table = $('#table_id').DataTable({
        data: jsonData,
        columns: [
            {"data": "username"},
            {"data": "reason"},
            {"data": "date"},
            {"data": "admin"},
            {"defaultContent": "<button type='button' class=\"btn btn-danger\" style='color: white;'><i class=\"fa fa-trash\"></i></button>"},
        ],
        responsive:true,
        destroy: true,
    });

    $('#table_id tbody').on( 'click', 'button', async function () {
        var data = table.row($(this).parents('tr')).data();
        console.log(JSON.stringify(data));
        let response = await fetch("../accessories/deleteWarns.php", {
            method:"POST",
            body:JSON.stringify(data),
            headers:{
                'Content-Type':'application/json',
                'Accept':'application/json'
            }
        });

        if (response.ok) {
            let json = await response.json();
            switch (json) {
                case "success":showalert("Sikeresen kitörölted a figyelmeztetést.","alert-success"); break;
            }
        } else {
            showalert("HTTP-Error: " + response.status,"alert-danger");
        }
    } );

}


async function manageWarn() {

}