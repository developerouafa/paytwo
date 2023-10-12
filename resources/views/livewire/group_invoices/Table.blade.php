<button class="btn btn-primary pull-right" wire:click="show_form_add" type="button">اضافة فاتورة جديدة </button><br><br>
<div class="table-responsive">
    <table class="table text-md-nowrap" id="example1" data-page-length="50"style="text-align: center">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم الخدمة</th>
                <th>اسم العميل</th>
                <th>تاريخ الفاتورة</th>
                <th>سعر الخدمة</th>
                <th>قيمة الخصم</th>
                <th>نسبة الضريبة</th>
                <th>قيمة الضريبة</th>
                <th>الاجمالي مع الضريبة</th>
                <th>نوع الفاتورة</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    @include('livewire.group_invoices.delete')
</div>
