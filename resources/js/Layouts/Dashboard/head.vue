<template>
    <head>

        <div v-if="$page.props.locale.locale == 'ar'" dir="rtl">
            <!-- Sidemenu css -->
            <link rel="stylesheet" href="assets/css-rtl/sidemenu.css">

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
