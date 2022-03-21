async function sendDatas () {

    let user = getCookie("username");
    let files = document.getElementById("file").files
    let files2 = document.getElementById("file2").files
    const formData = new FormData();
    for (let i = 0; i < files.length; i++) {
        let file = files[i]
        console.log(file);
        formData.append('files[]', file);
    }
    for (let i = 0; i < files2.length; i++) {
        let file = files2[i]
        console.log(file);
        formData.append('files[]', file);
    }

    let clid = document.getElementById("clid").value;

    let lenght = files.length;

    if (clid.length == 0) {return showalert("Érvénytelen TeamSpeak Azonosító","alert-danger");}
    if (lenght == 0) {return showalert("Kép nincs feltöltve!","alert-danger");}

    let response = await fetch("../accessories/upload.php?u="+user+"&c="+btoa(clid), {
        method: "POST",
        body: formData,
    });

    if (response.ok) { // if HTTP-status is 200-299
        // get the response body (the method explained below)
        let json = await response.json();
        switch (json) {
            case "success":showalert("Sikeresen feltöltötted a bizonyitékot.","alert-success"); break;
        }
    } else {
        showalert("HTTP-Error: " + response.status,"alert-danger");
    }
}