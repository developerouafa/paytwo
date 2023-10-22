<button class="btn btn-primary pull-right" wire:click="show_form_add" type="button"> {{__('Dashboard/services.addotheinvoice')}} </button><br><br>
<div class="table-responsive">
    <table id="example1" class="table key-buttons text-md-nowrap">
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
                <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
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
                    <td>{{$group_invoice->user->name}}</td>
                    <td> {{ $group_invoice->created_at->diffForHumans() }} </td>
                    <td> {{ $group_invoice->updated_at->diffForHumans() }} </td>
                    <td>
                        @can('Edit Group Invoices')
                            <button wire:click="edit({{ $group_invoice->id }})" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                        @endcan

                        @can('Delete Group Invoices')
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_invoice" wire:click="delete({{ $group_invoice->id }})" ><i class="fa fa-trash"></i></button>
                        @endcan

                        @can('Print Group Invoices')
                            <a wire:click="print({{ $group_invoice->id }})" class="btn btn-primary btn-sm" target="_blank" title="طباعه سند صرف"><i class="fas fa-print"></i></a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @include('livewire.group_invoices.delete')
</div>
