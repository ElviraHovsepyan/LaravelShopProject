@extends('layout')

@section('content')
<br>
<form>
    <select class="selectYear">
        <option selected disabled>Choose the year</option>
        @for($i = 2015; $i<= 2025; $i++)
            <option>{{ $i }}</option>
        @endfor
    </select>
</form>

<canvas id="popChart" width="600" height="400"></canvas>

@endsection

@section('rightBar')
@endsection

