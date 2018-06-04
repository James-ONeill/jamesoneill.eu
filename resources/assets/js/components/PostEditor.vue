<template>
    <div>
        <div class="bg-white mb-16 py-3 shadow -mt-8">
            <div class="flex items-center max-w-xl mx-auto">
                <div class="flex-grow mr-4">
                    <input
                        type="text"
                        class="bg-transparent font-bold px-6 py-2 rounded text-3xl text-blue focus:shadow-inner hover:shadow-inner transition-300 w-full focus:bg-grey-light focus:no-outline hover:bg-grey-light"
                        v-model="title"
                    />
                </div>

                <div
                    v-if="! published_at"
                    class="mr-2"
                >
                    <button
                        class="bg-blue inline-block py-3 px-6 rounded-full shadow text-white w-auto hover:no-underline focus:no-outline"
                        :class="{'opacity-25': submitting}"
                        :disabled="submitting"
                        type="submit"
                        @click.prevent="save(publish)"
                    >
                        Publish
                    </button>
                </div>

                <div
                    v-else
                    class="mr-2"
                >
                    <button
                        class="bg-white inline-block py-3 px-6 rounded-full text-blue w-auto hover:no-underline focus:no-outline"
                        :class="{'opacity-25': submitting}"
                        :disabled="submitting"
                        type="submit"
                        @click.prevent="save(unpublish)"
                    >
                        Unublish
                    </button>
                </div>

                <div>
                    <button
                        class="bg-blue inline-block py-3 px-6 rounded-full shadow text-white w-auto hover:no-underline focus:no-outline"
                        :class="{'opacity-25': submitting}"
                        :disabled="submitting"
                        type="submit"
                        @click.prevent="save"
                    >
                        Save
                    </button>
                </div>
            </div>
        </div>

        <ul
            v-if="hasErrors"
            class="list-reset max-w-xl mb-8 mx-auto"
        >
            <li
                v-for="(error, key) in errors"
                :key="key"
                class="text-red"
                v-text="error[0]"
            />
        </ul>

        <div class="border-t-4 max-w-xl mx-auto rounded" :class="hasErrors ? 'border-red' : 'border-blue'">
            <textarea
                class="border-none rounded bg-white-50 block mb-8 px-6 py-3 shadow transition-300 transition-bg w-full resize-none leading-loose tracking-wide focus:bg-white hover:bg-white focus:no-outline"
                name="body"
                rows="30"
                v-model="body"
            />
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
                id: null,
                title: 'New Post',
                body: '',
                published_at: null,
                errors: {},
                submitting: false,
                ...this.post,
            };
        },

        computed: {
            newPost() {
                return this.id != null;
            },

            httpMethod() {
                return this.id ? "put" : "post";
            },

            endpoint() {
                return `/dashboard/${this.endpointSuffix}`;
            },

            endpointSuffix() {
                return this.id ? `post/${this.id}` : "posts";
            },

            hasErrors() {
                return Object.keys(this.errors).length > 0;
            }
        },

        methods: {
            async save(after) {
                this.submitting = true;

                try {
                    const timer = new Promise(res => setTimeout(res, 300));

                    let response = await axios[this.httpMethod](this.endpoint, {
                        title: this.title,
                        body: this.body,
                    });

                    if (typeof after === "function") {
                        response = await after();
                    }

                    await Promise.all([ response, timer ]);

                    this.id = response.data.id;
                    this.title = response.data.title;
                    this.body = response.data.body;
                    this.published_at = response.data.published_at;

                    history.replaceState(null, null, `/dashboard/post/${this.id}/edit`);

                    this.submitting = false;
                } catch ({ response }) {
                    this.submitting = false;
                    this.errors = response.data.errors;
                }
            },

            async publish() {
                return axios.post('/dashboard/published-posts', {
                    post_id: this.id
                });
            },

            async unpublish() {
                return axios.delete('/dashboard/published-posts', {
                    data: { post_id: this.id }
                });
            },
        }
    };
</script>