<script setup>
    import mainsidebar from './main-sidebar.vue';
    import mainheader from './main-header.vue';

</script>
<template>
    <!-- Loader -->
        <div id="global-loader">
            <img src="assets/img/loader.svg" class="loader-img" alt="Loader">
        </div>
	<!-- /Loader -->
        <mainsidebar/>
	<!-- main-content -->
		<div class="main-content app-content">
            <mainheader/>
			<!-- container -->
			<div class="container-fluid">
                <slot/>
            </div>
        </div>
</template>
