var error1 = 'The field is required';
var error2 = 'Maximum 30 symbol';
var error3 = 'Maximum 10 symbol';
var error4 = 'Insert an image type file';
var error5 = 'Maximum 200 symbol';
$('#addForm span').css({'color':'red','margin-left':'5px'});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});

////////////////////  chart
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
    getDiagram(2018);
});

$('.selectYear').on('change',function () {
    var key = $('.selectYear').val();
    getDiagram(key);
});

/////////// price field

$('#price').keypress(function(e){
    var dotExist = (e.target.value.indexOf('.') !== -1);
    if(e.keyCode>47 && e.keyCode<58 || e.keyCode >37 && e.keyCode<40 || (e.keyCode == 46 && !dotExist)){
        return true;
    } else {
        return false;
    }
});

/////////////// validation

$('input,textarea').keydown(function () {
    $(this).next().hide();
});

$('#addForm').on('submit',function(e){
    e.preventDefault();
    $('#submitButton').attr('disabled','disabled');
    setTimeout(function () {
        $('#submitButton').removeAttr('disabled');
    },3000);
    var name = $('#name').val();
    var price = $('#price').val();
    var info = $('#info').val();
    var pic = $('#pic')[0].files[0];
    if (name.length < 1) {
        $('.firstSpan').text(error1);
        $('.firstSpan').show();
    } else if(name.length >30){
        $('.firstSpan').text(error2);
        $('.firstSpan').show();
    }
    if (price.length < 1) {
        $('.secondSpan').text(error1);
        $('.secondSpan').show();

    } else if(price.length >10){
        $('.secondSpan').text(error3);
        $('.secondSpan').show();
    }
    if (info.length < 1) {
        $('.thirdSpan').text(error1);
        $('.thirdSpan').show();
    } else if(info.length >200){
        $('.thirdSpan').text(error5);
        $('.thirdSpan').show();
    }
    if(pic){
        var fileType = pic['type'].split('/')[0];
        if(fileType != 'image'){
            $('.fourthSpan').text(error4);
            $('.fourthSpan').show();
        }
    }
    var data = new FormData;
    data.append('name',name);
    data.append('price',price);
    data.append('info',info);
    if(pic) data.append('pic',pic);
    var id = $('#hideID').val();
    var hide = $('#hideInput').val();
    var url;
    if(hide == 'insert'){
        url = '/addNew';
    } else if(hide == 'update') {
        url = '/update/'+id;
    }
    ajaxRequest(url,data,hide);
});


function ajaxRequest(url,data,hide){
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'JSON',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success:function(response){
            console.log(response);
            if(hide == 'insert'){
                alert('You have added a new Item');
            } else if(hide == 'update') {
                alert('You have updated the Item');
            }
        },
        error:function(response){
            console.log(response);
        }
    });
}

///////////////////  block users

$('.block-users').click(function () {
    var btnValue = $(this).text();
    var id = $(this).attr('id');
    if(btnValue=='Block'){
        $(this).text('Unblock');
        $.ajax({
            url: '/block',
            type: 'post',
            data: {id:id}
        }).done(function(response){
            console.log(response);

        });
    } else {
        $(this).text('Block');
        $.ajax({
            url: '/unBlock',
            type: 'post',
            data: {id:id}
        }).done(function(response){
            console.log(response);
            $(this).text('Unblock');
        });
    }
});

//////////////////  search

$('body').click(function () {
    $('.showResults').hide();
});
$('.search-query').keyup(function(){
    var key = $('.search-query').val();
    if(key==''){
        $('.showResults').empty();
        $('.showResults').hide();
    } else {
        $.ajax({
            url: '/search',
            type: 'post',
            data: {search:key}
        }).done(function (response) {
            console.log(response);
            if(response != ''){
                var product = JSON.parse(response);
                $('.showResults').empty();
                for(var x=0;x<product.length;x++){
                    $('.showResults').append('<a href="/productDetails/'+product[x]['id']+'"><p>'+product[x]['name']+'</p></a>');
                    $('.showResults').show();
                }
            }
        });
    }
});

//////////////////// scroll

var url = $(location).attr('pathname').split('/');
var page = url[1];
var id = url[2];
var number = 6;
var inProgress = false;
var key = $('.search-query').val();

$(window).scroll(function () {
    if($(window).scrollTop() + $(window).height() + 300 >= $(document).height() && inProgress == false){
        inProgress = true;
        $.ajax({
            url: '/scroll',
            type: 'post',
            data: {number:number, page:page, id:id, key:key}
        }).done(function (response) {
            console.log(response);
            if(response){
                var products = JSON.parse(response);
                for(var i = 0; i < products.length; i++){
                    $('.main-products-page').append('<li class="span3">\n' +
                        '                        <div class="product-box">\n' +
                        '                            <a href="/productDetails/'+products[i]["id"]+'"><img alt="" src="/public/themes/images/prPics/'+products[i]["pic"]+'.jpg"></a><br/>\n' +
                        '                            <a href="#" class="title">'+products[i]["name"]+'</a><br/>\n' +
                        '                            <p class="price">'+products[i]["price"]+'</p>\n' +
                        '                        </div>\n' +
                        '                    </li>');
                }
            }
            inProgress = false;
            number += 3;
        });
    }
});

////////////// add products

$('.addButton').click(function () {
    localStorage.setItem('buy',1);
    $('.buyProducts').show();
    var quant = $('#quantity').val();
    var id = $('.addButton').attr('productId');
    var arr = JSON.parse(localStorage.getItem('basket'));
    if(arr){
        arr[id] = quant;
    } else {
        arr = {};
        arr[id] = quant;
    }
    localStorage.setItem('basket',JSON.stringify(arr));
});

if(localStorage.getItem('buy')==1){
    $('.buyProducts').show();
} else {
    $('.buyProducts').hide();
}

$('.buyProducts').click(function () {
    $('.buyProducts').hide();
    localStorage.removeItem('buy');
    var arr = JSON.parse(localStorage.getItem('basket'));
    $.ajax({
        url:'/buy',
        type:'post',
        data: {arr:arr},
    }).done(function(response){
        console.log(response);
        localStorage.removeItem('basket');
    });
});


/////////show pdf

$('.modalA').click(function () {
    var key = $(this).text();
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/getInvoices/"+key, true);
    xhr.responseType = "blob";
    xhr.onload = function (e) {
        if (this.status === 200) {
            // console.log(this.response);
            var file = new Blob([this.response], {type: 'application/pdf'});
            var fileURL = URL.createObjectURL(file);
            document.querySelector("iframe").src = fileURL;
        }
    };
    xhr.send();
});





