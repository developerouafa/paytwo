<template>
    <div class="ml-2 mr-2">
        <div v-if="$page.props.locale.locale == 'en'">
            <Link :href="route('language', 'ar')" class="flex text-black-200 hover:text-black transition">
                <Icon class="w-5 h-5" :name="'ar'" />
                <p class="mr-1 ml-1">{{ __('ar') }}</p>
            </Link>
        </div>

        <div v-if="$page.props.locale.locale != 'en' && $page.props.locale.locale != 'ar'">
            <Link :href="route('language', 'ar')" class="flex text-black-200 hover:text-black transition">
                <Icon class="w-5 h-5" :name="'ar'" />
                <p class="mr-1 ml-1">{{ __('ar') }}</p>
            </Link>
        </div>
        <div v-else-if="$page.props.locale.locale == 'ar'">
            <Link :href="route('language', 'en')" class="flex text-black-200 hover:text-black transition">
                <Icon class="w-5 h-5" :name="'en'" />
                <p class="mr-1 ml-1">{{ __('en') }}</p>
            </Link>
        </div>
    </div>
</template>

<script setup>
import Icon from './Icon.vue';
</script>
