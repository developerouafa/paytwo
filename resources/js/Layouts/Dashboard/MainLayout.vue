<script setup>
    import headestyle from './head.vue';
    import mainsidebar from './main-sidebar.vue';
    import mainheader from './main-header.vue';
    import sidebar from './sidebar.vue';
    import models from './models.vue';
    import footerf from './footer.vue';
</script>
<template>
    <headestyle/>
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
                <!-- <sidebar/>
                <models/>
                <footerf/> -->
            </div>
        </div>
</template>



