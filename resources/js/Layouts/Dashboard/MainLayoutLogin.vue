<script setup>
    import headestyle from './head.vue';
</script>
<template>
    <headestyle/>
    <!-- Loader -->
        <div id="global-loader">
            <img src="assets/img/loader.svg" class="loader-img" alt="Loader">
        </div>
	<!-- /Loader -->
        <slot/>
</template>



