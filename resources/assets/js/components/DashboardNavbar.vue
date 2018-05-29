<template>
    <div class="bg-blue flex items-center justify-between mb-8 px-6">
        <div>
            <a class="font-semibold opacity-75 text-sm text-white uppercase hover:opacity-100 hover:no-underline" href="/dashboard">
                Dashboard
            </a>
        </div>
        <div
            class="cursor-pointer px-2 py-2 relative"
            @click="accountMenuOpen = !accountMenuOpen"
        >
            <img
                class="Gravatar rounded-full shadow"
                :src="gravatar"
            >

            <div
                v-if="accountMenuOpen"
                class="absolute pin-b pin-x -mt-px"
                @click.stop=""
            >
                <div class="absolute bg-white min-w-40 pin-r pin-t">
                    <ul class="list-reset my-2">
                        <li>
                            <a
                                href="#"
                                class="block leading-normal px-4 text-blue hover:no-underline hover:bg-grey-lighter"
                                @click.prevent="logout"
                            >
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                accountMenuOpen: false,
            };
        },

        watch: {
            accountMenuOpen(newVal) {
                const method = newVal
                    ? document.addEventListener
                    : document.removeEventListener;

                method('click', this.hideAccountMenu);
            }
        },

        computed: {
            gravatar() {
                return `${this.user.gravatar}?s=60`;
            },
        },

        methods: {
            hideAccountMenu() {
                this.accountMenuOpen = false;
            },

            async logout() {
                const response = await axios.post('/logout');
                window.location.href = response.request.responseURL;
            },
        }
    };
</script>

<style scoped>
.Gravatar {
    height: 60px;
    width: 60px;
}
</style>
