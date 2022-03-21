let dataTable = [];
let minTable = [];
let dayTable = [];
let activeTable = [];

function fillDate() {
    const currentDate = new Date();
    const month = currentDate.getMonth()+1;
    const year = currentDate.getFullYear();
    const days = new Date(year,month,0).getDate();
    document.getElementById("month_placeholder").innerText = year + ". "+currentDate.toLocaleString("hu-HU", { month: "long" });
    for (let i = 2; i < days+1; i++) {
        let d = new Date(currentDate.getFullYear()+"-"+(currentDate.getMonth()+1)+"-"+i);
        let day = d.toISOString().split('T');
        dataTable.push({date:day[0],min:0,activetime:0})
    }
}

function splitTable(table){
    for (let i = 0; i < table.length; i++) {
        minTable.push(table[i].min);
        dayTable.push(table[i].date);
        activeTable.push(table[i].activetime)
    }


}

fetch('../accessories/loadProfileData.php', {mode:'no-cors'})
    .then(res => res.json())
    .then(x => load(x));

async function load(data) {
    await fillDate()
    for (let i = 0; i < data.length; i++) {
        for (let j = 0; j < dataTable.length; j++) {
         if (data[i].date == dataTable[j].date) {
             dataTable[j].min = parseInt(data[i].min);
             dataTable[j].activetime = parseInt(data[i].activetime);
         }
        }
    }
    await splitTable(dataTable)
    showChart();
}

function showChart() {


    const data = {
        labels: dayTable,
        datasets: [{
            label: 'Szolgálati idő (Perc)',
            data: minTable,
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        },{
                label: 'Szerveren eltöltött ídő (Perc)',
                data: activeTable,
                fill: false,
                borderColor: 'rgb(173,15,29)',
                tension: 0.1
        }]
    };

    new Chart(document.getElementById("myChart"), {
        type: 'line',
        data: data,
    });


}
