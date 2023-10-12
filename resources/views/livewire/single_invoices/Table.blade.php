<button class="btn btn-primary pull-right" wire:click="show_form_add" type="button">اضافة فاتورة جديدة </button><br><br>
<div class="table-responsive">
    <table class="table text-md-nowrap" id="example1" data-page-length="50"style="text-align: center">
        <thead>
        <tr>

        </tr>
        </thead>
        <tbody>
        @foreach ($single_invoices as $single_invoice)
            <tr>

            </tr>
        @endforeach
    </table>

    @include('livewire.single_invoices.delete')

</div>
