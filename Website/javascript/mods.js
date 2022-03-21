
async function searchByDate () {
    let startDate = $('#startDate').datepicker('getUTCDate').toISOString().split('T');
    let endDate = $('#endDate').datepicker('getUTCDate').toISOString().split('T');

    let formData = {
        startDate: startDate[0],
        endDate:endDate[0],
    };

    let response = await fetch("../accessories/loadModerators.php", {
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
        await showTable(json);
    } else {
        showalert("HTTP-Error: " + response.status,"alert-danger");
    }




}

$( document ).ready(function() {
    $('.actual_range').datepicker({
        format: 'mm/dd/yyyy',
        language:'hu',
        startDate: '-2m',
        format: 'yyyy-mm-dd',
    });
    $('#event_period').datepicker({
        inputs: $('.actual_range'),
    });
});


function showTable(jsonData) {
   var table = $('#table_id').DataTable({
        data: jsonData,

        columns: [
            {"data": "username"},
            {"data": "name"},
            {"data": "uID"},
            {"data": "rank"},
            {"data": "min"},
            {"data": "activetime"},
            {"data": "connection"},
            {"data": "warns"},
            {"data": "lastSeen"},
            {"defaultContent": "<button type='button' class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#myModal\" style='color: white;'><i class=\"fas fa-ellipsis-v\"></i></button>"}
        ],
        responsive:true,
        destroy: true,
    })

    $('#table_id tbody').on( 'click', 'button', async function () {
        var data = table.row($(this).parents('tr')).data();
        await fetch('../insideModal.php?target='+data.username, {mode: 'no-cors'})
            .then(res => res.text())
            .then(x => {document.getElementById("content").innerHTML = x});

        $('#myModal').modal('show');
    } );

}