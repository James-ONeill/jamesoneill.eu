<template>
    <div class="mailing-list-signup">
        <form v-if="!success" @submit="submit">
            <h2 class="mailing-list-signup__title">
                Do you want an email whenever I post something new?
            </h2>

            <p>Enter your email address and I'll keep you updated.</p>

            <div v-if="error != null">{{error}}</div>

            <div class="mailing-list-signup__fields">
                <input
                    class="mailing-list-signup__email-input"
                    type="email"
                    v-model="email"
                    placeholder="Your email address"
                />

                <button
                    class="mailing-list-signup__button"
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