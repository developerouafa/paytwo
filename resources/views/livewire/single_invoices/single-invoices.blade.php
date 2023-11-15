<div>
    @if ($catchError)
        <div class="alert alert-danger" id="success-danger">
            <button type="button" class="close" data-dismiss="alert">x</button>
            {{ $catchError }}
        </div>
    @endif

    @if ($InvoiceSaved)
        <div class="alert alert-info"> {{__('Dashboard/services.dataaddsuccessfully')}} </div>
    @endif

    @if ($InvoiceUpdated)
        <div class="alert alert-info"> {{__('Dashboard/services.dataeditsuccessfully')}}</div>
    @endif

    @if($show_table)
        @can('Show Single Invoices')
            @include('livewire.single_invoices.Table')
        @endcan
    @else
        @can('Create Group Invoices')
            <form wire:submit.prevent="store" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col">
                        <label> {{__('Dashboard/services.client')}} </label>
                        <select wire:model="client_id" class="form-control" required>
                            <option value=""  >-- {{__('Dashboard/services.Choosefromthelist')}} --</option>
                            @foreach($Clients as $Client)
                                <option value="{{$Client->id}}">{{$Client->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <label> {{__('Dashboard/services.Invoicetype')}} </label>
                        <select wire:model="type" class="form-control" {{$updateMode == true ? 'disabled':''}}>
                            <option value="">-- {{__('Dashboard/services.Choosefromthelist')}} --</option>
                            <option value="0"> {{__('Dashboard/services.noselectionyet')}} </option>
                            <option value="1"> {{__('Dashboard/services.monetary')}} </option>
                            <option value="2"> {{__('Dashboard/services.Okay')}} </option>
                            <option value="3"> {{__('Dashboard/services.Banktransfer')}} </option>
                            <option value="4"> {{__('Dashboard/services.card')}} </option>
                        </select>
                    </div>
                </div><br>

                <div class="row row-sm">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mg-b-0"></h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mg-b-0 text-md-nowrap" style="text-align: center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th> {{__('Dashboard/services.nameservice')}} </th>
                                                <th> {{__('Dashboard/services.priceservice')}} </th>
                                                <th> {{__('Dashboard/services.discountvalue')}} </th>
                                                <th> {{__('Dashboard/services.Taxrate')}} </th>
                                                <th> {{__('Dashboard/services.Taxvalue')}} </th>
                                                <th> {{__('Dashboard/services.Totalwithtax')}} </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">#</th>
                                                <td>
                                                    <select wire:model="product_id" class="form-control" wire:change="get_price" id="exampleFormControlSelect1">
                                                        <option value="">-- {{__('Dashboard/services.Choosefromthelist')}} --</option>
                                                        @foreach($Products as $Product)
                                                            <option value="{{$Product->id}}">{{$Product->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input wire:model="price" type="text" class="form-control" readonly></td>
                                                <td><input wire:model="discount_value" type="text" class="form-control"></td>
                                                <th><input wire:model="tax_rate" type="text" class="form-control"></th>
                                                <td><input type="text" class="form-control" value="{{$tax_value}}" readonly ></td>
                                                <td><input type="text" class="form-control" readonly value="{{$subtotal + $tax_value }}"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!-- bd -->
                            </div><!-- bd -->
                        </div><!-- bd -->
                    </div>
                </div>

                <input class="btn btn-outline-success" type="submit" value=" {{__('Dashboard/services.save')}} ">
            </form>
        @endcan
    @endif
</div>

