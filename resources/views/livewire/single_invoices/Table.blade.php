<button class="btn btn-primary pull-right" wire:click="show_form_add" type="button"> {{__('Dashboard/services.addotheinvoice')}}</button><br><br>
<div class="table-responsive">
    <table class="table text-md-nowrap" id="example1" data-page-length="50"style="text-align: center">
        <thead>
        <tr>
            <th>#</th>
            <th> {{__('Dashboard/services.nameservice')}} </th>
            <th> {{__('Dashboard/services.client')}} </th>
            <th> {{__('Dashboard/services.dateinvoice')}} </th>
            <th> {{__('Dashboard/services.priceservice')}} </th>
            <th> {{__('Dashboard/services.discountvalue')}} </th>
            <th> {{__('Dashboard/services.Taxrate')}} </th>
            <th> {{__('Dashboard/services.Taxvalue')}} </th>
            <th> {{__('Dashboard/services.Totalwithtax')}} </th>
            <th> {{__('Dashboard/services.Invoicetype')}} </th>
            <th> {{__('Dashboard/users.createdbyuser')}} </th>
            <th> {{__('Dashboard/services.Processes')}} </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($single_invoices as $single_invoice)
            <tr>
                <td>{{ $loop->iteration}}</td>
                <td>{{ $single_invoice->Service->name }}</td>
                <td>{{ $single_invoice->Client->name }}</td>
                <td>{{ $single_invoice->invoice_date }}</td>
                <td>{{ number_format($single_invoice->price, 2) }}</td>
                <td>{{ number_format($single_invoice->discount_value, 2) }}</td>
                <td>{{ $single_invoice->tax_rate }}%</td>
                <td>{{ number_format($single_invoice->tax_value, 2) }}</td>
                <td>{{ number_format($single_invoice->total_with_tax, 2) }}</td>
                <td>{{ $single_invoice->type == 1 ? 'نقدي':'اجل' }}</td>
                <td>{{$single_invoice->user->name}}</td>
                <td>
                    <button wire:click="edit({{ $single_invoice->id }})" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_invoice" wire:click="delete({{ $single_invoice->id }})" ><i class="fa fa-trash"></i></button>
                    <button wire:click="print({{ $single_invoice->id }})" class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                </td>
            </tr>

        @endforeach
    </table>

    @include('livewire.single_invoices.delete')

</div>
