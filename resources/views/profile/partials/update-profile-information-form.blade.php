
<div class="card">
    <div class="card-body">
            <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" autocomplete="off">
                @csrf
                @method('patch')
                <div class="mb-4 main-content-label">{{__('Dashboard/profile.personalinformation')}}</div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">{{__('Dashboard/profile.name')}}</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="name_{{app()->getLocale()}}" required="" class="form-control" value="{{Auth::user()->name}}"  autofocus autocomplete="name" >
                                <x-input-error class="mt-2" :messages="$errors->get('name_{{app()->getLocale()}}')" />
                                <input type="hidden" name="profileid" value="{{Auth::user()->profileuser->id}}">
                                <input type="hidden" name="user_id" value="{{Auth::user()->profileuser->user_id}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">{{__('Dashboard/profile.phone')}}</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="phone" class="form-control" value="{{Auth::user()->phone}}" autofocus autocomplete="phone" >
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">{{__('Dashboard/profile.clienType')}}</label>
                            </div>
                            <div class="col-md-9">
                                <select name="clienType" id="select-beast" class="form-control  nice-select  custom-select">
                                    <option value="{{ Auth::user()->profileuser->clienType }}">
                                        @if (Auth::user()->profileuser->clienType == 1)
                                            {{__('Dashboard/users.individual')}}
                                        @else
                                            {{__('Dashboard/users.company')}}
                                        @endif
                                    </option>
                                    <option value="1">{{__('Dashboard/users.individual')}}</option>
                                    <option value="0">{{__('Dashboard/users.company')}}</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('clienType')" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">{{__('Dashboard/profile.nationalIdNumber')}}</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="nationalIdNumber" class="form-control" value="{{Auth::user()->profileuser->nationalIdNumber}}" autofocus autocomplete="nationalIdNumber" >
                                <x-input-error class="mt-2" :messages="$errors->get('nationalIdNumber')" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">{{__('Dashboard/profile.commercialRegistrationNumber')}}</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="commercialRegistrationNumber" class="form-control" value="{{Auth::user()->profileuser->commercialRegistrationNumber}}" autofocus autocomplete="commercialRegistrationNumber" >
                                <x-input-error class="mt-2" :messages="$errors->get('commercialRegistrationNumber')" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">{{__('Dashboard/profile.taxNumber')}}</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="taxNumber" class="form-control" value="{{Auth::user()->profileuser->taxNumber}}" autofocus autocomplete="taxNumber" >
                                <x-input-error class="mt-2" :messages="$errors->get('taxNumber')" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">{{__('Dashboard/profile.adderss')}}</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="address" class="form-control" value="{{Auth::user()->profileuser->adderss}}" autofocus autocomplete="address" >
                                <x-input-error class="mt-2" :messages="$errors->get('address')" />
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="card-footer text-left">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">{{__('Dashboard/profile.Update Profile')}}</button>
                        </div>
                    </div>
            </form>
    </div>
</div>
