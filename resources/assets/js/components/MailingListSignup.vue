<template>
    <div>
        <form v-if="!success" @submit="submit">
            <h2 class="red">Do you want an email whenever I post something new?</h2>
            <p>Enter your email address and I will keep you updated.</p>
            <div v-if="error != null">{{error}}</div>
            <input type="email" v-model="email" placeholder="Your email address" />
            <button type="submit" @click="submit" :disabled="email == ''">Sign Up</button>
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

                axios.post("/mailing-list/members", { email: this.email }).then(response => {
                    this.error = null;
                    this.success = true;
                }).catch(error => {

                    this.error = error.response.status == 422
                        ? error.response.data.errors.email[0]
                        : "There appears to be some kind of error 😕";
                    console.log(error.response.data)
                });
            }
        }
    }
</script>