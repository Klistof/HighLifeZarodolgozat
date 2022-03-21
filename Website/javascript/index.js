fetch('../accessories/loadProfileData.php', {mode:'no-cors'})
    .then(res => res.json())
    .then(x => load(x));

function load(json) {
    console.log(json)
    document.getElementById("seen").innerHTML = json[0].lastSeen;
    document.getElementById("con").innerHTML = json[0].connection;
    document.getElementById("rank").innerHTML = json[0].rank;
    document.getElementById("warns").innerHTML = json[0].warns;
    document.getElementById("prove").innerHTML = json[0].upload;
}
