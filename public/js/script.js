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

/////////////////////////////////// price field

$('#price').keypress(function(e){
    var dotExist = (e.target.value.indexOf('.') !== -1);
    if(e.keyCode>47 && e.keyCode<58 || e.keyCode >37 && e.keyCode<40 || (e.keyCode == 46 && !dotExist)){
        return true;
    } else {
        return false;
    }
});

///////////////////////////////////// validation

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
            // console.log(response);
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
var number;
if(url[3]){
   number = 6 + 3*url[3];
} else {
    number = 6;
}

var inProgress = false;
var key = $('.search-query').val();
var result = 0;
var increase = 0;
$(window).scroll(function () {
    if(($(window).scrollTop() + $(window).height() + 300 >= $(document).height()) && (inProgress == false) && (result == 0)){
        inProgress = true;
        // console.log(number);
        $.ajax({
            url: '/scroll',
            type: 'post',
            data: {number:number, page:page, id:id, key:key}
        }).done(function (response) {
            if(response.length > 2){
                increase++;
                var products = JSON.parse(response);
                appendResults(products);
                changeUrl(increase);
            } else {
                result = 1;
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
        localStorage.removeItem('basket');
    });
});

/////////////////////show pdf

$('.modalA').click(function () {
    var key = $(this).text();
    showPdf(key);
    changeUrl(key);
});

function showPdf(key){
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/getInvoices/"+key, true);
    xhr.responseType = "blob";
    xhr.onload = function (e) {
        if (this.status === 200) {
            $("#myModal").modal("show");
            // console.log(this.response);
            var file = new Blob([this.response], {type: 'application/pdf'});
            var fileURL = URL.createObjectURL(file);
            document.querySelector("iframe").src = fileURL;
        }
    };
    xhr.send();
}

///////////////change URL

var newUrl;
function changeUrl(key) {
    var oldUrl = $(location).attr('pathname');
    var spl = oldUrl.split('/');
    var method = spl[1];

    if(page=='category' || page=='subCategory' || page=='products'){
        var a = oldUrl.split(method);
        var b = a[1].split('/');
        if(b.length > 2){
            var last = b[2];
            newUrl = oldUrl.replace(last,'');
            newUrl = newUrl+key;
        } else {
            newUrl = oldUrl+'/'+key;
        }
    } else if(page=='myInvoices'){
        newUrl = oldUrl+'/'+key;
    }
    history.pushState({}, null, newUrl);
}

function urlReverse(){
    var url = $(location).attr('pathname');
    url = url.substr(0,11);
    history.pushState({}, null, url);
}

$('#myModal').css('display','none');
$('#myModal').on('hidden', function () {
    urlReverse();
    $('#myModal').css('display','none');
});


///////////////////// sort products

 $('.firstCheck').prop('checked',true);
 $('.firstCheck').on('change',function () {
     if($(this).is(':checked')){
         $(this).closest('li').find(".secondCheck").prop('checked',true);
         $(this).prop('checked',true);
     } else {
         $(this).closest('li').find(".secondCheck").prop('checked',false);
         $(this).prop('checked',false);
     }
 });

function checkUrl() {
    var url = $(location).attr('pathname');
    url = url.split('/');
    if((url[1]=='myInvoices') && (url[2] != '')){
        var key = url[2];
        showPdf(key);
    }
    if(url[1]=='category'){
        $('.firstCheck').prop('checked',false);
        $('.secondCheck').prop('checked',false);
        var x = url[2]-1;
        $('.firstCheck:eq('+x+')').prop('checked',true);
        $('.firstCheck:eq('+x+')').closest('li').find(".secondCheck").prop('checked',true);
        if((url[2])=='5'){
            $('.firstCheck:eq(3)').prop('checked',true);
            $('.firstCheck:eq(3)').closest('li').find(".secondCheck").prop('checked',true);
        }
    }
    if(url[1]=='register'){
       var promocode = $(location).attr('href');
       promocode = promocode.split('?promocode=');
       console.log(promocode[1]);
        if(promocode[1]){
            promocode = promocode[1];
            $('#hiddenInput').val(promocode);
        }
    }
}
checkUrl();

var priceResult;
$('#priceInputRange').on('input',function () {
    priceResult = $('#priceInputRange').val();
    $('.priceValue').text(priceResult);
});
$('#filter').click(function () {
    var subcatIds = [];
    result = 1;
    priceResult = $('.priceValue').text();
    if(priceResult != ''){
        var pr = priceResult;
    }
   $('.secondCheck').each(function () {
       if($(this).prop('checked') == true){
           var subId = $(this).attr('subcatId');
           subcatIds.push(subId);
       }
   });
    $.ajax({
        url:'/filter',
        type:'post',
        data:{subcatIds:subcatIds, pr:pr}
    }).done(function (response) {
        var products = JSON.parse(response);
        $('.main-products-page').empty();
        appendResults(products);
    });
});

function appendResults(products){
    for(var i = 0; i < products.length; i++){
        if(products[i]["storage"]["quantity"]>0){
            var includeText = 'Available : '+products[i]["storage"]["quantity"];
        } else {
            var includeText = 'No exists at this moment';
        }
        $('.main-products-page').append('<li class="span3">\n' +
            '                        <div class="product-box">\n' +
            '                            <a href="/productDetails/'+products[i]["id"]+'"><img alt="" src="/public/themes/images/prPics/'+products[i]["pic"]+'.jpg"></a><br/>\n' +
            '                            <a href="#" class="title">'+products[i]["name"]+'</a><br/>\n' +
            '                            <p class="price">$'+products[i]["price"]+'</p>\n' +
            '                            <p class="exists">'+includeText+'</p>\n' +
            '                        </div>\n' +
            '                    </li>');
    }
}

/////////////////// promocodes

$('.editPromocode').click(function () {
    var name = $(this).parent().siblings().children('.nameInput').val();
    var active = $(this).parent().siblings().children('.activeInput').val();
    var discount = $(this).parent().siblings().children('.discInput').val();
    var period = $(this).parent().siblings().children('.periodInput').val();
    sendPromocodes(name,active,discount,period);
});

$('.addPromocode').click(function(){
    var name = $(this).parent().siblings().children('.nameInput').val();
    var active = $(this).parent().siblings().children('.activeInput').val();
    var discount = $(this).parent().siblings().children('.discInput').val();
    var period = $(this).parent().siblings().children('.periodInput').val();
    sendPromocodes(name,active,discount,period);
});

function sendPromocodes(name,active,discount,period){
    $.ajax({
        url:'/promocode',
        type:'post',
        data:{name:name,active:active,discount:discount,period:period}
    }).done(function(response){
        console.log(response);
    });
}

/////////////////// storage

$('.editStorage').click(function () {
    var quantity = $(this).parent().siblings().children('.quantity').val();
    var id = $(this).parent().siblings().children('.idSpan').text();
    $.ajax({
        url: '/quant',
        type: 'post',
        data: {quantity:quantity,id:id}
    }).done(function (response) {
        console.log(response);
    });
});