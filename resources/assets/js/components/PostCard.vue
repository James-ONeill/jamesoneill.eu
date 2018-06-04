<template>
    <div class="bg-white border-blue border-t-4 flex flex-col h-full justify-between p-4 rounded shadow">
        <div class="mb-8">
            <h1
                class="mb-1 mt-0 text-xl"
                v-text="post.title"
            />

            <div
                class="text-grey-darker text-blue text-sm"
                v-text="publishedAt ? 'Published' : 'Unpublished'"
            />
        </div>

        <div class="flex justify-end">
            <div>
                <a
                    class="border-2 border-blue bg-blue block rounded-full shadow text-white mx-1 px-3 py-2 text-center text-xs w-16 hover:no-underline"
                    :href="`/dashboard/post/${post.id}/edit`"
                >
                    Edit
                </a>
            </div>

            <div>
                <button
                    v-if="publishedAt"
                    class="bg-white border-2 border-blue block mx-1 px-3 py-2 rounded-full shadow text-blue text-xs w-24 focus:no-outline hover:no-underline"
                    @click="unpublish"
                >
                    Unublish
                </button>

                <button
                    v-else
                    class="bg-blue border-2 border-blue block mx-1 px-3 py-2 rounded-full shadow text-white text-xs w-24 focus:no-outline hover:no-underline"
                    @click="publish"
                >
                    Publish
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['post'],

    data() {
        return {
            publishedAt: this.post.published_at
        }
    },

    methods: {
        async publish() {
            const response = await axios.post('/dashboard/published-posts', {
                post_id: this.post.id,
            });

            this.publishedAt = response.data.published_at;
        },

        async unpublish() {
            const response = await axios.delete('/dashboard/published-posts', {
                data: { post_id: this.post.id }
            });

            this.publishedAt = response.data.published_at;
        },
    }
}
</script>

