<template>
    <div :class="['bg-white shadow border-t-4 px-6 py-8 rounded', errors.length ? 'border-red' : 'border-blue']">
        <p
            v-for="(error, index) in errors"
            :key="index"
            class="mb-6 mt-0 text-red-light text-base"
            v-text="error[0]"
        />

        <label
            class="block font-bold mb-2"
            for="title"
        >
            Title
        </label>

        <input
            class="border-none bg-grey-lightest block mb-8 px-4 py-3 shadow w-full"
            type="text"
            name="title"
            v-model="title"
        >

        <textarea
            class="border-none bg-grey-lightest block mb-8 px-4 py-3 shadow w-full resize-none leading-loose tracking-wide"
            name="body"
            rows="30"
            v-model="body"
        />

        <div class="text-right">
            <button
                class="bg-blue inline-block py-3 px-6 rounded-full shadow text-white w-auto hover:no-underline"
                type="submit"
                @click.prevent="submit"
            >
                Save
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            post: Object,
        },

        data() {
            return {
                title: '',
                body: '',
                errors: {},
                ...this.post,
            };
        },

        computed: {
            httpMethod() {
                return this.post ? "put" : "post";
            },

            endpoint() {
                return `/dashboard/${this.endpointSuffix}`;
            },

            endpointSuffix() {
                return this.post ? `post/${this.post.id}` : "posts";
            }
        },

        methods: {
            async submit() {
                try {
                    const response = await axios[this.httpMethod](this.endpoint, {
                        title: this.title,
                        body: this.body,
                    });

                    window.location.href = response.request.responseURL;
                } catch ({ response }) {
                    switch (response.status) {
                        case 405:
                             window.location.href = response.request.responseURL;
                             return;
                        case 422:
                            this.errors = response.data.errors;
                            return;
                        default:
                    }
                }
            },
        }
    };
</script>