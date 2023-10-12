<button class="btn btn-primary pull-right" wire:click="show_form_add" type="button"> {{__('Dashboard/services.addotheinvoice')}} </button><br><br>
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
                <th> {{__('Dashboard/services.Processes')}} </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($group_invoices as $group_invoice)
                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $group_invoice->Group->name }}</td>
                    <td>{{ $group_invoice->Client->name }}</td>
                    <td>{{ $group_invoice->invoice_date }}</td>
                    <td>{{ number_format($group_invoice->price, 2) }}</td>
                    <td>{{ number_format($group_invoice->discount_value, 2) }}</td>
                    <td>{{ $group_invoice->tax_rate }}%</td>
                    <td>{{ number_format($group_invoice->tax_value, 2) }}</td>
                    <td>{{ number_format($group_invoice->total_with_tax, 2) }}</td>
                    <td>{{ $group_invoice->type == 1 ? 'نقدي':'اجل' }}</td>
                    <td>
                        <button wire:click="edit({{ $group_invoice->id }})" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_invoice" wire:click="delete({{ $group_invoice->id }})" ><i class="fa fa-trash"></i></button>
                        <a  wire:click="print({{ $group_invoice->id }})" class="btn btn-primary btn-sm" target="_blank" title="طباعه سند صرف"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @include('livewire.group_invoices.delete')
</div>
