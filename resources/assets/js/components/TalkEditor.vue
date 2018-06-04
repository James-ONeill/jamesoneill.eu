<template>
    <div>
        <div class="bg-white mb-16 py-3 shadow -mt-8">
            <div class="flex items-center max-w-xl mx-auto">
                <div class="flex-grow mr-4">
                    <input
                        type="text"
                        class="bg-transparent font-bold px-6 py-2 rounded text-3xl text-blue focus:shadow-inner hover:shadow-inner transition-300 w-full focus:bg-grey-light focus:no-outline hover:bg-grey-light"
                        placeholder="New Talk"
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
            class="list-reset max-w-md mb-8 mx-auto"
        >
            <li
                v-for="(error, key) in errors"
                :key="key"
                class="text-red"
                v-text="error[0]"
            />
        </ul>

        <div class="max-w-md mx-auto">
            <div class="bg-white border-t-4 px-6 py-8 rounded shadow" :class="hasErrors ? 'border-red' : 'border-blue'">
                <label class="block font-bold mb-2" for="event">Event</label>
                <input
                    class="border-none bg-grey-lightest block mb-8 px-4 py-3 shadow w-full"
                    type="text"
                    v-model="event"
                >

                <label class="block font-bold mb-2" for="event">Slide Deck URL</label>
                <input
                    class="border-none bg-grey-lightest block mb-8 px-4 py-3 shadow w-full"
                    type="text"
                    name="slide_deck_url"
                    v-model="slide_deck_url"
                >

                <label class="block font-bold mb-2" for="event">Video URL</label>
                <input
                    class="border-none bg-grey-lightest block mb-8 px-4 py-3 shadow w-full"
                    type="text"
                    name="video_url"
                    v-model="video_url"
                >
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        talk: Object,
    },


    data() {
        return {
            id: null,
            title: null,
            event: null,
            slide_deck_url: null,
            video_url: null,
            published_at: null,
            errors: {},
            submitting: false,
            ...this.talk,
        };
    },

    computed: {
        newTalk() {
            return this.id != null;
        },

        httpMethod() {
            return this.id ? "put" : "post";
        },

        endpoint() {
            return `/dashboard/${this.endpointSuffix}`;
        },

        endpointSuffix() {
            return this.id ? `talk/${this.id}` : "talks";
        },

        hasErrors() {
            return Object.keys(this.errors).length;
        },
    },

    methods: {
        async save(after) {
            this.submitting = true;

            try {
                const timer = new Promise(res => setTimeout(res, 300));

                let response = await axios[this.httpMethod](this.endpoint, {
                    title: this.title,
                    event: this.event,
                    slide_deck_url: this.slide_deck_url,
                    video_url: this.video_url,
                });

                if (typeof after === "function") {
                    response = await after();
                }

                await Promise.all([ response, timer ]);

                this.id = response.data.id;
                this.title = response.data.title;
                this.body = response.data.body;
                this.published_at = response.data.published_at;

                this.errors = {};

                history.replaceState(null, null, `/dashboard/talk/${this.id}/edit`);

                this.submitting = false;
            } catch ({ response }) {
                this.submitting = false;
                this.errors = response.data.errors;
            }
        },

        async publish() {
            return axios.post('/dashboard/published-talks', {
                talk_id: this.id
            });
        },

        async unpublish() {
            return axios.delete('/dashboard/published-talks', {
                data: { talk_id: this.id }
            });
        },
    }
}
</script>

