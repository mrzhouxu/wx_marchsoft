<template>
	<div>
		<pageHeader></pageHeader>
        <pageMenu></pageMenu>
	</div>
</template>
<style>
	
</style>
<script>
	import pageHeader from './layout/Train.vue'
    import pageMenu from './layout/Cultivate.vue'
    export default{
        components : {
            pageHeader,
            pageMenu
        }
    }
</script>