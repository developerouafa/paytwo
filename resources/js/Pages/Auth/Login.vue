<script setup>
    import languageselector from '@/Shared/LanguageSelector.vue';
    import Checkbox from '@/Components/Checkbox.vue';
    import InputError from '@/Components/InputError.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';

    defineProps({
        canResetPassword: Boolean,
        status: String
    });

    const form = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = () => {
        form.post(route('login'), {
            onFinish: () => form.reset('password'),
        });
    };
</script>
<template>
    <link href="assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css" rel="stylesheet">
    <Head title="Login"/>

    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                        <img src="assets/img/media/login.png" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
                    </div>
                </div>
            </div>
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>
            <!-- The content half -->
            <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
                <div class="login d-flex align-items-center py-2">
                    <!-- Demo content-->
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="card-sigin">
                                    <div class="mb-5 d-flex"> <a href="{{ url('/' . $page='index') }}"><img src="assets/img/brand/favicon.png" class="sign-favicon ht-40" alt="logo"></a><h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">{{ __('title') }}</h1></div>
                                    <div class="card-sigin">
                                        <div class="main-signup-header">
                                            <h2>{{ __('Welcome back!') }}</h2>
                                            <h5 class="font-weight-semibold mb-4">{{__('Please sign in to continue.')}}</h5>
                                            <languageselector/>
                                            <form @submit.prevent="submit">
                                                <div class="form-group">
                                                    <label for="email">{{__('Email')}}<span class="text-danger">*</span></label>
                                                    <input id="email" type="email" class="form-control" v-model="form.email" required autofocus autocomplete="username" placeholder="example@gmail.com">
                                                    <InputError class="mt-2" :message="form.errors.email" />
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__('Password')}}<span class="text-danger">*</span></label>
                                                    <input id="password" class="form-control" v-model="form.password" placeholder="Enter your password" type="password" required autocomplete="current-password">
                                                    <InputError class="mt-2" :message="form.errors.password" />
                                                </div>
                                                <div class="block mt-4">
                                                    <label for="remember_me" class="inline-flex items-center">
                                                    <Checkbox id="remember_me" name="remember" v-model:checked="form.remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                                        <span class="ml-3 mr-3 text-gray-600">  {{__('Remembre Me')}}</span>
                                                    </label>
                                                </div>
                                                <button class="btn btn-main-primary btn-block">{{__('Sign In')}}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                </div>
            </div><!-- End -->
        </div>
    </div>
</template>
