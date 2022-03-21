async function memberManagment(uID,type) {
    let formData = {
        uID:uID,
        typ:type
    };

    let response = await fetch("../accessories/memberManagement.php", {
        method: "POST",
        body: JSON.stringify(formData),
        headers : {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    });

    if (response.ok) { 
        let json = await response.json();

        switch (json) {
            case "rankdown":showalert("Az általad kiválasztott felhasználó le lett fokozva","alert-warning"); document.getElementById("rank:"+uID).innerText = parseInt(document.getElementById("rank:"+uID).innerText)-1; break;
            case "rankup": showalert("Az általad kiválasztott felhasználó elő lett léptetve","alert-success"); document.getElementById("rank:"+uID).innerText = parseInt(document.getElementById("rank:"+uID).innerText)+1; break;
            case "delete": showalert("Az általad kiválasztott felhasználó törölve lett az adatbázisból","alert-danger"); document.getElementById("row:"+uID).remove(); break;
        }
    } else {
        showalert("HTTP-Error: " + response.status,"alert-danger");
    }

    let rank = parseInt(document.getElementById("rank:"+uID).innerText);
    console.log(rank);
    switch (rank) {
        case 0: document.getElementById("rankdown-"+uID).style.display = 'none'; break;
        case 1: document.getElementById("rankdown-"+uID).style.display = 'inline'; document.getElementById("rankup-"+uID).style.display = 'inline';break;
        case 2: document.getElementById("rankup-"+uID).style.display = 'none'; break;

    }


}

async function removeInvite(uID) {

    let formData = {
        uID:uID
    };

    let response = await fetch("../accessories/removeInvite.php", {
        method: "POST",
        body: JSON.stringify(formData),
        headers : {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    });

    if (response.ok) {
        let json = await response.json();


        if (json == "success"){
            showalert("Az általad kiválasztott meghívó törölve lett az adatbázisból","alert-danger");
            document.getElementById("row:"+uID).remove();
        }

    } else {
        showalert("HTTP-Error: " + response.status,"alert-danger");
    }
}

async function addNewUser(){

    let formData = {
        email:document.getElementById("email").value,
        uID:document.getElementById("ts").value,
        ip:location.hostname
    };

        let response = await fetch("../accessories/addUser.php", {
            method: "POST",
            body: JSON.stringify(formData),
            headers : {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

        if (response.ok) {
            let json = await response.json();

            if (json == "invalidEmailOruID") {
                showalert("Érvénytelen Email vagy Azonosító", "alert-danger")
            }
            if (json == "success") {
                showalert("Sikeresen meghívtad az általad beírt felhasználót!","alert-success")
            }
            if (json == "exist"){
                showalert("Ez a TeamSpeak azonosító vagy email, már létezik az adatbázisban", "alert-warning")
            }
            if (json == "mailerror"){
                showalert("Az email kiszolgáló nem válaszol vagy hiba történt!", "alert-danger")
            }

        } else {
            showalert("HTTP-Error: " + response.status,"alert-danger");
        }

}