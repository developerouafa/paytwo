@extends('Dashboard/layouts.master')
@section('title')
    {{__('Dashboard/permissions.userpermissions')}}
@endsection
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/users.users')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                    {{__('Dashboard/permissions.userpermissions')}}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session()->has('Add'))
        <script>
            window.onload = function() {
                notif({
                    msg: {{__('Dashboard/users.addsuccesspermission')}},
                    type: "success"
                });
            }

        </script>
    @endif

    @if (session()->has('edit'))
        <script>
            window.onload = function() {
                notif({
                    msg: {{__('Dashboard/users.updatesuccesspermission')}},
                    type: "success"
                });
            }

        </script>
    @endif

    @if (session()->has('delete'))
        <script>
            window.onload = function() {
                notif({
                    msg: {{__('Dashboard/users.deletesuccesspermission')}},
                    type: "error"
                });
            }
        </script>
    @endif

    <!-- row -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <div class="col-lg-12 margin-tb">
                                <div class="pull-right">
                                    @can('Create role')
                                        <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}">{{__('Dashboard/permissions.add')}}</a>
                                    @endcan
                                </div>
                            </div>
                            <br>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mg-b-0 text-md-nowrap table-hover" data-page-length="50" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('Dashboard/permissions.name')}}</th>
                                        <th>{{__('Dashboard/permissions.PROCESSES')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $key => $role)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @can('Show roles')
                                                    <a class="btn btn-success btn-sm"
                                                        href="{{ route('roles.show', $role->id) }}">{{__('Dashboard/permissions.show')}}</a>
                                                @endcan

                                                @can('Modify roles')
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('roles.edit', $role->id) }}">{{__('Dashboard/permissions.modify')}}</a>
                                                @endcan

                                                @if ($role->name !== 'owner')
                                                    @can('Delete role')
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy',
                                                        $role->id], 'style' => 'display:inline']) !!}
                                                        <input type="submit" class="btn btn-danger btn-sm" value="{{__('Dashboard/permissions.delete')}}">
                                                        {!! Form::close() !!}
                                                    @endcan
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/div-->
        </div>
    <!-- row closed -->

</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
