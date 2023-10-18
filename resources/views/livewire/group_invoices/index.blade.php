@extends('Dashboard.layouts.master')
@section('css')

@endsection
@section('title')
    {{__('Dashboard/services.group_services')}}
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/services.invoices')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{__('Dashboard/services.group_services')}}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <livewire:group-invoices />
                </div>
            </div>
        </div>

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
<script>
    $(function() {
        jQuery("[name=select_all]").click(function(source) {
            checkboxes = jQuery("[name=delete_select]");
            for(var i in checkboxes){
                checkboxes[i].checked = source.target.checked;
            }
        });
    })
</script>

<script>
    $(function() {
        jQuery("[name=select_all]").click(function(source) {
            checkboxes = jQuery("[name=delete_select]");
            for(var i in checkboxes){
                checkboxes[i].checked = source.target.checked;
            }
        });
    })
</script>

<script type="text/javascript">
    $(function () {
        $("#btn_delete_all").click(function () {
            var selected = [];
            $("#example input[name=delete_select]:checked").each(function () {
                selected.push(this.value);
            });

            if (selected.length > 0) {
                $('#delete_select').modal('show')
                $('input[id="delete_select_id"]').val(selected);
            }
        });
    });
</script>
@endsection
