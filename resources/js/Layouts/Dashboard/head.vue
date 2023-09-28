<template>
    <head>
        <!-- Favicon -->
        <link rel="icon" href="assets/img/brand/favicon.png" type="image/x-icon"/>
        <!-- Icons css -->
        <link href="assets/css/icons.css" rel="stylesheet">
        <!--  Custom Scroll bar-->
        <link href="assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet"/>
        <!--  Sidebar css -->
        <link href="assets/plugins/sidebar/sidebar.css" rel="stylesheet">

        <div v-if="$page.props.locale.locale == 'ar'" dir="rtl">
            <!-- Sidemenu css -->
            <link rel="stylesheet" href="assets/css-rtl/sidemenu.css">

            <!-- Index  -->
            <!--  Owl-carousel css-->
            <link href="assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" />
            <!-- Maps css -->
            <link href="assets/plugins/jqvmap/jqvmap.min.css" rel="stylesheet">

            <!--- Style css -->
            <link href="assets/css-rtl/style.css" rel="stylesheet">
            <!--- Dark-mode css -->
            <link href="assets/css-rtl/style-dark.css" rel="stylesheet">
            <!---Skinmodes css-->
            <link href="assets/css-rtl/skin-modes.css" rel="stylesheet">
        </div>
        <div v-if="$page.props.locale.locale == 'en'" dir="ltr">
            <!-- Sidemenu css -->
            <link rel="stylesheet" href="assets/css/sidemenu.css">

            <!--  Owl-carousel css-->
            <link href="assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" />
            <!-- Maps css -->
            <link href="assets/plugins/jqvmap/jqvmap.min.css" rel="stylesheet">

            <!--- Style css -->
            <link href="assets/css/style.css" rel="stylesheet">
            <!--- Dark-mode css -->
            <link href="assets/css/style-dark.css" rel="stylesheet">
            <!---Skinmodes css-->
            <link href="assets/css/skin-modes.css" rel="stylesheet">
        </div>
        <div v-if="$page.props.locale.locale != 'en' && $page.props.locale.locale != 'ar'" dir="ltr">
            <!-- Sidemenu css -->
            <link rel="stylesheet" href="assets/css/sidemenu.css">

            <!--  Owl-carousel css-->
            <link href="assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" />
            <!-- Maps css -->
            <link href="assets/plugins/jqvmap/jqvmap.min.css" rel="stylesheet">

            <!--- Style css -->
            <link href="assets/css/style.css" rel="stylesheet">
            <!--- Dark-mode css -->
            <link href="assets/css/style-dark.css" rel="stylesheet">
            <!---Skinmodes css-->
            <link href="assets/css/skin-modes.css" rel="stylesheet">
        </div>
    </head>
</template>
<script setup>


</script>
