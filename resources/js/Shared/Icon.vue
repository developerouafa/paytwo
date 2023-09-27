<template>
    <img v-if="name === 'en'" x="0px" y="0px" viewBox="0 0 473.68 473.68" style="enable-background:new 0 0 473.68 473.68;" xml:space="preserve" src="/assets/img/flags/images.png">
    <img v-else-if="name === 'ar'" x="0px" y="0px" viewBox="0 0 473.68 473.68" style="enable-background:new 0 0 473.68 473.68;" xml:space="preserve" src="/assets/img/flags/images.png">
</template>

<script>
export default {
    name: "Icon",
    props: ['name']
}
</script>
