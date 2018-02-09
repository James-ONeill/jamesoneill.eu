<template>
    <div class="bg-white shadow border-t-8 border-blue py-2 px-8 text-right mb-8">
        <img class="rounded-full shadow" :src="gravatar">
    </div>
</template>

<script>
    export default {
        props: ['user'],

        computed: {
            gravatar() {
                return `${this.user.gravatar}?s=60`;
            }
        }
    };
</script>