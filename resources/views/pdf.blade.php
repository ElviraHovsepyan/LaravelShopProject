<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<style>
    header {
        padding: 20px 0;
    }
    .title {
        margin: 50px 0;
    }
    footer {
        padding:20px 0 ;
    }
    .invSpan{
        float: right;
        margin: 20px 30px;
        font-size: 30px;
    }
    .logo{
        margin: 20px;
    }
    .table-responsive{
        width: 80%;
        margin-left: 10%;
    }
    .title{
       text-align: center;
    }
    .tPrice{
        float: right;
        font-size: 20px;
        margin-right: 10%;
    }
</style>
</head>
<body>

<div>
    <img src="{{ asset('/public/themes/images/logo.png') }}" class="logo" alt="logo">
    <span class="invSpan">INVOICE</span>
</div>

<div class="table-responsive">
    <h2 class="title">Details</h2>
    <table class="table table-bordered">
        @if(!empty($data))
            <tr>
                <td>Quantity</td>
                <td>Element name</td>
                <td>Element price</td>
                <td>Total price</td>
            </tr>
            @foreach($data as $product)
                <tr>
                    <td>
                        {{$product->quantity}}
                    </td>
                    <td>
                        {{$product->el_name}}
                    </td>
                    <td>
                        {{$product->el_price}} $
                    </td>
                    <td>
                        {{$product->total_price}} $
                    </td>
                </tr>
            @endforeach
        @endif
    </table>
</div>
<p class="tPrice">Total : {{ $price }} $</p>

</body>
</html>
