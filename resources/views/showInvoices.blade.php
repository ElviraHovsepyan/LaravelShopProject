@extends('layout')

@section('content')
    <h3>My invoices</h3>
    <div class="mainDiv">
        <input type="hidden" value="{{ $invoices }}">
        <table class="table table-striped">
            <tr>
                <th>Invoice name</th>
                <th>Create Date</th>
            </tr>
            @foreach($invoices as $invoice)
                <tr>
                    <td>
                        <a href="#" data-toggle="modal" data-target="#myModal" class="modalA">{{ $invoice->inv_name }}</a>
                    </td>
                    <td>{{ $invoice->created_at }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="modal fade modalDiv" id="myModal" role="dialog">
        <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Invoice</h4>
                </div>
                <div class="modal-body ng-scope pdfobject-container">
                    <iframe type="application/pdf" src="" frameborder="0" width="100%" id="embedPdf" height="400px"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('rightBar')
@endsection





