@extends('layout')

@section('content')
<br>
<select class="selectPeriod">
    <option selected disabled>Choose the period</option>
        <option>Last Month</option>
        <option>Last 4 Months</option>
</select>

<canvas id="pieChart" width="600" height="400"></canvas>

@endsection

@section('rightBar')
@endsection

