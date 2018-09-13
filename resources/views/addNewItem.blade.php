@extends('layout')

@section('content')
    <section class="header_text sub">
        <img class="pageBanner" src="/public/themes/images/pageBanner.png" alt="New products" >
        <h4><span>Add New Item</span></h4>
    </section>

    <section class="main-content">

        <div class="row">
            <div class="span9">
                <ul class="thumbnails listing-products">

                    <form id="addForm" style="margin-left: 40px" method="post" action="{{ route('addNewItem') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" value="insert" id="hideInput">
                        <input type="text" name="name" placeholder="Name" id="name"><span class="firstSpan"></span><br><br>
                        <input type="text" name="price" placeholder="Price" id="price"><span class="secondSpan"></span><br><br>
                        <textarea name="info" placeholder="Info" id="info"></textarea><span class="thirdSpan"></span><br><br>
                        <input type="file" name="pic" id="pic"><span class="fourthSpan"></span><br><br>
                        <input type="submit" id="submitButton">
                    </form>

                    @if(count($errors) > 0)
                        @foreach($errors->all() as $error)
                            <p>{!! $error !!}</p>
                        @endforeach
                    @endif

                </ul>
                <hr>
                <div class="pagination pagination-small pagination-centered">

                </div>
            </div>

@endsection






