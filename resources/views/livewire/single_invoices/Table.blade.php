<button class="btn btn-primary pull-right" wire:click="show_form_add" type="button"> {{__('Dashboard/services.addotheinvoice')}}</button><br><br>
<div class="table-responsive">
    <table id="example1" class="table key-buttons text-md-nowrap">
        <thead>
        <tr>
            <th>#</th>
            <th> {{__('Dashboard/services.invoicenumber')}} </th>
            <th> {{__('Dashboard/services.nameservice')}} </th>
            <th> {{__('Dashboard/services.client')}} </th>
            <th> {{__('Dashboard/services.dateinvoice')}} </th>
            <th> {{__('Dashboard/services.priceservice')}} </th>
            <th> {{__('Dashboard/services.discountvalue')}} </th>
            <th> {{__('Dashboard/services.Taxrate')}} </th>
            <th> {{__('Dashboard/services.Taxvalue')}} </th>
            <th> {{__('Dashboard/services.Totalwithtax')}} </th>
            <th> {{__('Dashboard/services.type')}} </th>
            <th> {{__('Dashboard/services.Invoicestatus')}} </th>
            <th> {{__('Dashboard/services.Invoicetype')}} </th>
            <th> {{__('Dashboard/users.createdbyuser')}} </th>
            <th>{{__('Dashboard/sections_trans.created_at')}}</th>
            <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
            <th> {{__('Dashboard/services.Processes')}} </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($single_invoices as $single_invoice)
            <tr>
                <td>{{ $loop->iteration}}</td>
                <td>{{ $single_invoice->invoice_number }}</td>
                <td>{{ $single_invoice->Service->name }}</td>
                <td>{{ $single_invoice->Client->name }}</td>
                <td>{{ $single_invoice->invoice_date }}</td>
                <td>{{ number_format($single_invoice->price, 2) }}</td>
                <td>{{ number_format($single_invoice->discount_value, 2) }}</td>
                <td>{{ $single_invoice->tax_rate }}%</td>
                <td>{{ number_format($single_invoice->tax_value, 2) }}</td>
                <td>{{ number_format($single_invoice->total_with_tax, 2) }}</td>
                <td>
                    @if ($single_invoice->type == 1)
                        {{__('Dashboard/services.monetary')}}
                       @can('Create Receipt')
                            <form action="{{ route('Receipt.createrc') }}" method="POST">
                                @csrf
                                <input type="hidden" name="invoice_id" value="{{ $single_invoice->id }}" />
                                <input type="hidden" name="client_id" value="{{ $single_invoice->Client->id }}" />
                                    <button type="submit" class="btn btn-purple">
                                        {{__('Dashboard/receipt_trans.addreceipt')}}
                                    </button>
                            </form>
                        @endcan
                    @elseif ($single_invoice->type == 0)
                        {{__('Dashboard/services.noselectionyet')}}
                    @elseif ($single_invoice->type == 2)
                        @can('Create Catch Payment')
                            <form action="{{ route('Payment.createpy') }}" method="POST">
                                @csrf
                                <input type="hidden" name="invoice_id" value="{{ $single_invoice->id }}" />
                                <input type="hidden" name="client_id" value="{{ $single_invoice->Client->id }}" />
                                    <button type="submit" class="btn btn-purple">
                                        {{__('Dashboard/payment_trans.addpayment')}}
                                    </button>
                            </form>
                        @endcan
                        {{__('Dashboard/services.Okay')}}
                    @elseif ($single_invoice->type == 3)
                        {{__('Dashboard/services.Banktransfer')}}
                    @elseif ($single_invoice->type == 4)
                        {{__('Dashboard/services.card')}}
                    @endif
                </td>
                <td>
                    @if ($single_invoice->invoice_status == 1)
                        {{__('Dashboard/services.Sent')}}
                    @elseif ($single_invoice->invoice_status == 2)
                        {{__('Dashboard/services.Under review')}}
                    @elseif ($single_invoice->invoice_status == 3)
                        {{__('Dashboard/services.Complete')}}
                    @endif
                </td>
                <td>
                    @if ($single_invoice->invoice_type == 1)
                        {{__('Dashboard/services.Draft')}}
                    @elseif ($single_invoice->invoice_type == 2)
                        {{__('Dashboard/services.Paid')}}
                    @elseif ($single_invoice->invoice_type == 3)
                        {{__('Dashboard/services.Canceled')}}
                    @endif
                </td>
                <td>{{$single_invoice->user->name}}</td>
                <td> {{ $single_invoice->created_at->diffForHumans() }} </td>
                <td> {{ $single_invoice->updated_at->diffForHumans() }} </td>
                <td>

                    <button wire:click="updatepaymenttype({{ $single_invoice->id }})" class="btn btn-primary btn-sm">update payment type</button>

                    @can('Edit Single Invoices')
                        <button wire:click="edit({{ $single_invoice->id }})" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                    @endcan

                    @can('Delete Single Invoices')
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_invoice" wire:click="delete({{ $single_invoice->id }})" >
                            <i class="fa fa-trash"></i>
                        </button>
                    @endcan

                    @can('Print Single Invoices')
                        <button  wire:click="print({{ $single_invoice->id }})" class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                    @endcan
                </td>
            </tr>

        @endforeach
    </table>

    @include('livewire.single_invoices.delete')

</div>
