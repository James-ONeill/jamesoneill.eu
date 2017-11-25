<template>
    <div class="border p-6 rounded bg-white border-grey my-8">
        <form v-if="!success" @submit="submit">
            <h2 class="text-base mb-4">
                Do you want an email whenever I post something new?
            </h2>

            <p class="text-sm mb-4">Enter your email address and I'll keep you updated.</p>

            <div v-if="error != null">{{error}}</div>

            <div class="flex">
                <input
                    class="text-sm py-3 px-3 rounded bg-grey-light border border-grey-dark flex-1"
                    type="email"
                    v-model="email"
                    placeholder="Your email address"
                />

                <button
                    v-bind:class="{'text-sm py-3 px-3 rounded bg-red text-white ml-4': true, 'opacity-50': email == ''}"
                    type="submit"
                    @click="submit"
                    :disabled="email == ''"
                >
                    Sign Up
                </button>
            </div>
        </form>
        <div v-else>
            <p>
                <strong>Thanks</strong>
                I'll drop you an email when my next post is done.
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                email: '',
                error: null,
                success: false
            };
        },

        methods: {
            submit(event) {
                event.preventDefault();

                axios
                    .post("/mailing-list/members", { email: this.email })
                    .then(response => {
                        this.error = null;
                        this.success = true;
                    })
                    .catch(error => {
                        this.error = error.response.status == 422
                            ? error.response.data.errors.email[0]
                            : "There appears to be some kind of error 😕";
                    });
            }
        }
    }
</script>