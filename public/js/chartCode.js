var data;
var popCanvas = $("#popChart");
function getDiagram(key){
    $.ajax({
        url: '/chart',
        type: 'post',
        data: {key:key}
    }).done(function (response) {
        data = JSON.parse(response);
        var barChart = new Chart(popCanvas, {
            type: 'bar',
            data: {
                labels: ["Jenuary", "February", "March", "April", "May", "June", "July", "August", "September", "October","November","December"],
                datasets: [{
                    label: 'Added Products in '+key,
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                    ]
                }]
            }
        });
    });
}

$(document).ready(function () {
    var url = $(location).attr('pathname').split('/');
    if(url[1]=='chart'){
        getDiagram(2018);
    }
    if(url[1]=='sale'){
        getPieDiagram(1);
    }
});

$('.selectYear').on('change',function () {
    var key = $('.selectYear').val();
    getDiagram(key);
});

///////////////////////////////////////////pie chart

var key1;
$('.selectPeriod').on('change',function () {
    var period = $('.selectPeriod').val();
    if(period=='Last Month'){
        key1 = 1;
    } else {
        key1 = 4;
    }
    getPieDiagram(key1);
});

var pieCanvas = $("#pieChart");
function getPieDiagram(key1){
    $.ajax({
        url: '/sale',
        type: 'post',
        data: {key1:key1}
    }).done(function (response) {
        data = JSON.parse(response);
        var lab = [];
        var dt = [];
        for(var i in data){
            lab.push(i);
            dt.push(data[i]);
        }
        console.log(dt);
        var data = {
            labels: lab,
            datasets: [
                {
                    data: dt,
                    backgroundColor: ["#FF6384", "#63FF84", "#84FF63", "#8463FF", "#6384FF"]
                }]
        };
        var chartOptions = {
            rotation: -Math.PI,
            cutoutPercentage: 0,
            animation: {
                animateRotate: false,
                animateScale: true
            }
        };
        var pieChart = new Chart(pieCanvas, {
            type: 'pie',
            data: data,
            options: chartOptions
        });
    });
}
