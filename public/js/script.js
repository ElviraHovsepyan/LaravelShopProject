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
            // console.log(response);
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
            // console.log(response);

        });
    } else {
        $(this).text('Block');
        $.ajax({
            url: '/unBlock',
            type: 'post',
            data: {id:id}
        }).done(function(response){
            // console.log(response);
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
        if(promocode[1]){
            promocode = promocode[1];
            $('#hiddenInput').val(promocode);
        }
    }
    if(url[1]=='products'){
        var checkData = JSON.parse(localStorage.getItem('filter'));
        if(checkData != null){
            var subcatIds = checkData['check'];
            var pr = checkData['price'];
            result = 1;
            $('.firstCheck').prop('checked',false);
            $('.secondCheck').prop('checked',false);
            $('.priceValue').text(pr);
            $('.secondCheck').each(function () {
                for(var i in subcatIds){
                    if($(this).attr('subcatid') == subcatIds[i]){
                        $(this).prop('checked',true);
                    }
                }
            });
            filterAjaxRequest(subcatIds,pr);
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
    filterAjaxRequest(subcatIds,pr);
});

function filterAjaxRequest(subcatIds,pr){
    $.ajax({
        url:'/filter',
        type:'post',
        data:{subcatIds:subcatIds, pr:pr}
    }).done(function (response) {
        var products = JSON.parse(response);
        $('.main-products-page').empty();
        appendResults(products);
        setToLocalStorageFilterData(subcatIds,pr);
    });
}
function setToLocalStorageFilterData(subcatIds,pr){
    localStorage.removeItem('filter');
    var arr={};
    arr['check']=subcatIds;
    arr['price']=pr;
    localStorage.setItem('filter',JSON.stringify(arr));
}
$('#clear').click(function () {
    localStorage.removeItem('filter');
    location.reload();
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
    var id = $(this).attr('promId');
    var name = $(this).parent().siblings().children('.nameInput').val();
    var active = $(this).parent().siblings().children('.activeInput').val();
    var discount = $(this).parent().siblings().children('.discInput').val();
    var period = $(this).parent().siblings().children('.periodInput').val();
    sendPromocodes(name,active,discount,period,id);
});

$('.addPromocode').click(function(){
    var id = 0;
    var name = $(this).parent().siblings().children('.nameInput').val();
    var active = $(this).parent().siblings().children('.activeInput').val();
    var discount = $(this).parent().siblings().children('.discInput').val();
    var period = $(this).parent().siblings().children('.periodInput').val();
    sendPromocodes(name,active,discount,period,id);
});

function sendPromocodes(name,active,discount,period,id){
    $.ajax({
        url:'/promocode',
        type:'post',
        data:{name:name,active:active,discount:discount,period:period,id:id}
    }).done(function(response){
        // console.log(response);
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
        // console.log(response);
    });
});

////////////////////////subscriptions

$('.sendSubscribe').click(function () {
    var email = $('#subscribe').val();
    var valid =  validateEmail(email);
    if(valid){
        $.ajax({
            url:'/subscribe',
            type: 'post',
            data: {email:email}
        }).done(function(response){
            var sub = JSON.parse(response);
            $('.alertResponse').text(sub);
        });
    } else {
        alert('Please enter a valid Email');
    }
});

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

$('.editSubscription').click(function () {
    var id = $(this).attr('subscrId');
    var header = $(this).parent().siblings().children('.headerInput').val();
    var body = $(this).parent().siblings().children('.bodyInput').val();
    var active = $(this).parent().siblings().children('.activeInput').val();
    var date = $(this).parent().siblings().children('.dateInput').val();
    sendSubscription(header,body,active,date,id);
});

$('.addSubscription').click(function () {
    var id = 0;
    var header = $(this).parent().siblings().children('.headerInput').val();
    var body = $(this).parent().siblings().children('.bodyInput').val();
    var active = $(this).parent().siblings().children('.activeInput').val();
    var date = $(this).parent().siblings().children('.dateInput').val();
    sendSubscription(header,body,active,date,id);
});

function sendSubscription(header,body,active,date,id){
    $.ajax({
        url:'/subscrAdmin',
        type:'post',
        data:{header:header,body:body,active:active,date:date,id:id}
    }).done(function(response){
        // console.log(response);
    });
}

$('.deleteSub').click(function () {
    var id = $(this).attr('subscrId');
    $.ajax({
        url:'/delSub',
        type:'post',
        data:{id:id}
    }).done(function (response) {
        // console.log(response);
    });
});

//////////////////////////// csv

$("#csvForm").on('submit', function(e){
    e.preventDefault();
    var file = $('#UploadCsv')[0].files[0];
    var data = new FormData;
    data.append('file',file);
    $.ajax({
        url:'/import',
        type: 'post',
        dataType: 'JSON',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success:function(response){
            // console.log(response);
            if(response=='Structure of your csv file is incorrect!'){
                appentToModal(response,0);
            } else {
                // console.log(response);
                appentToModal(response,1);
            }
        },
        error:function(response){
            // console.log(response);
        }
    });
});

function appentToModal(response,check){
    if(check==0){
        $('.modalTable').html("<tr>\n" +
            "                                    <th>Product Name</th>\n" +
            "                                    <th>Product description</th>\n" +
            "                                    <th>Product picName</th>\n" +
            "                                    <th>Product price</th>\n" +
            "                                </tr><tr>\n" +
            "                                    <td>Leather Shoulder Bag</td>\n" +
            "                                    <td>Shaped from pebbled lambskin leather and set off with a polished stacked-T logo</td>\n" +
            "                                    <td>pic555</td>\n" +
            "                                    <td>543</td>\n" +
            "                                </tr>\n" +
            "                                <tr>\n" +
            "                                    <td>Reversible Faux Leather Tote & Wristlet</td>\n" +
            "                                    <td>Supersoft faux leather flips inside-out for a reversible tote while a matching wristlet</td>\n" +
            "                                    <td>pic111</td>\n" +
            "                                    <td>97</td>\n" +
            "                                </tr>\n" +
            "                                <tr>\n" +
            "                                    <td>Elle Drop Earrings</td>\n" +
            "                                    <td>Signature earrings flaunting a colorful stone are reimagined in a smaller, wear-anywhere size.</td>\n" +
            "                                    <td>pic444</td>\n" +
            "                                    <td>47</td>\n" +
            "                                </tr>\n" +
            "                                <tr>\n" +
            "                                    <td>Elton Station Cuff Bracelet</td>\n" +
            "                                    <td>A slender wrist cuff detailed with intricate etchings is finished with endcaps of richly textured and boldly colored jewels.</td>\n" +
            "                                    <td>pic75</td>\n" +
            "                                    <td>37</td>\n" +
            "                                </tr>");
        $('.alertMessage').text(response);
        $('.example').text('Example: ');

    } else {
        $('.modalTable').empty();

        var arr = Object.keys(response[0]);
        $('.modalTable').append('<td>#</td>');
        for(var i=0; i<arr.length; i++){
            $('.modalTable').append('<td><select class="firstSelect">');
                for(var j in arr){
                    $('.firstSelect:eq('+i+')').append('<option>'+arr[j]+'</option>');
                }
            $('.modalTable').append('</select></td>');
        }
        for(var k in response){
            $('.modalTable').append('<tr><td><input type="checkbox" class="checkCsvRows"></td>');
                for(var j in response[k]){
                    $('.modalTable tr:eq('+k+')').append('<td class="csvTd">'+response[k][j]+'</td>');
                }
            $('.modalTable').append('</tr>');
        }

        $('.firstSelect').each(function(i){
            $(this).children('option:eq('+i+')').attr('selected','selected');
        });

        $('.example').text('Select columns');
        $('.alertMessage').text('Choose the rows you want to import');
        $('.csvButton').show();
    }
    $(document).scrollTop(0);
    $("#myModal2").modal("show");
}
//
// $('.firstSelect').on('change',function () {
//
//
// });

$('.csvButton').click(function () {
    var arr2 = [];
   $('.checkCsvRows').each(function () {
       var arr = [];
       if($(this).is(':checked')){
           $(this).closest('tr').children('.csvTd').each(function(){
               arr.push($(this).text());
           });
          arr2.push(arr);
       }
   });

    var arrSelect = [];
    $('.firstSelect').each(function(){
       var value = $(this).val();
       arrSelect.push(value);
   });

    $.ajax({
        url:'/insert',
        type:'post',
        data:{data:arr2,selectData:arrSelect}
    }).done(function (response) {
        console.log(response);
        if(response=='success'){
            $("#myModal2").modal("hide");
        }
    });
});
