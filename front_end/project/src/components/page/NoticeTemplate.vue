<template>
    <div id="noticePoint">
        {{msg}}
    </div>
</template>

<script>
export default {
    data(){
        return {
            msg: 'Hello, World!'
        }
    }
}
</script>

<style scoped>
#noticePoint{
    height: 200px;
    width: 100px;
}
</style>

