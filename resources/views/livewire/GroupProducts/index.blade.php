
<div class="d-flex justify-content-between pb-1">
    <button class="btn btn-primary pull-right" wire:click="show_form_add" type="button">
        {{__('Dashboard/services.addsubservice')}}
    </button><br><br>
    <button class="btn btn-danger pull-left" wire:click="deleteall" type="button">
        {{__('Dashboard/messages.Deleteall')}}
    </button><br><br>
</div>
    @can('Show Group Services')
        <div class="table-responsive">
            <table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50" style="text-align: center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th> {{__('Dashboard/services.nameservice')}} </th>
                        <th>{{__('Dashboard/services.totalofferincludingtax')}}</th>
                        <th>{{__('Dashboard/services.description')}}</th>
                        <th>{{__('Dashboard/users.createdbyuser')}}</th>
                        <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                        <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
                        <th>{{__('Dashboard/services.Processes')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groups as $group)
                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td>{{ $group->name }}</td>
                            <td>{{ number_format($group->Total_with_tax, 2) }}</td>
                            <td>{{ \Str::limit($group->notes, 50) }}</td>
                            <td>{{$group->user->name}}</td>
                            <td> {{ $group->created_at->diffForHumans() }} </td>
                            <td> {{ $group->updated_at->diffForHumans() }} </td>
                            <td>
                                @can('Edit Group Services')
                                    <button wire:click="edit({{ $group->id }})" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                                @endcan

                                @can('Delete Group Services')
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteGroup{{$group->id}}"><i class="fa fa-trash"></i></button>
                                @endcan
                            </td>
                        </tr>
                    @include('livewire.GroupProducts.delete')
                    @endforeach
            </table>
        </div>
    @endcan

