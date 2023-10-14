<div class="card">
    <div class="card-body">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Update Password') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </header>

        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6" autocomplete="off">
            @csrf
            @method('put')

            <div class="form-group ">
                <div class="row">
                    <div class="col-md-3">
                        <label for="current_password" class="form-label">{{__('Current Password')}}</label>
                    </div>
                    <div class="col-md-9">
                        <x-text-input class="form-control"  id="current_password" name="current_password" type="password" autocomplete="current-password" />
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="form-group ">
                <div class="row">
                    <div class="col-md-3">
                        <label for="password" class="form-label">{{__('New Password')}}</label>
                    </div>
                    <div class="col-md-9">
                        <x-text-input class="form-control"  id="password" name="password" type="password" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="form-group ">
                <div class="row">
                    <div class="col-md-3">
                        <label for="password_confirmation" class="form-label">{{__('Confirm Password')}}</label>
                    </div>
                    <div class="col-md-9">
                        <x-text-input class="form-control"  id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                @if (session('status') === 'password-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                    >{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
    </div>
</div>
