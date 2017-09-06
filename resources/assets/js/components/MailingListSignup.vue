<template>
    <div>
        <form v-if="!success" @submit="submit">
            <div v-if="error != null">{{error}}</div>
            <input type="text" v-model="email" />
            <button type="submit" @click="submit" :disabled="email == ''">Sign Up</button>
        </form>
        <div v-else>
            Thanks for signing up.
            I'll drop you an email as soon as I post something new.gi
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