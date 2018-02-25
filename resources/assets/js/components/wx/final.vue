<template>
	<div>
		<pageHeader></pageHeader>
        <pageMenu></pageMenu>
	</div>
</template>
<style>
	
</style>
<script>
	import pageHeader from './layout/header.vue'
    import pageMenu from './layout/menu.vue'
    export default{
        components : {
            pageHeader,
            pageMenu
        }
    }
</script>