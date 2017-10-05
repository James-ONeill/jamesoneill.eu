<template>
    <form action="/login" method="POST" class="login-form">
        <slot></slot>

        <div :class="{'login_form__input-group': true, 'login_form__input-group--has-errors': errors}">
            <div :class="{ 'login-form__input-container': true, 'login-form__input-container--focused': emailFocused }">
                <div class="login-form__icon-container">
                    <svg width="20px" height="17px" viewBox="0 0 20 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-565.000000, -254.000000)">
                                <g transform="translate(551.000000, 240.000000)">
                                    <g transform="translate(14.000000, 14.500000)">
                                        <rect stroke="#979797" stroke-width="2" x="1" y="1" width="18" height="14" rx="3"></rect>
                                        <path d="M8.5685583,10.3119497 L0.397460938,2 L19.532959,2 L11.4261387,10.3067555 C10.6546613,11.0972594 9.38842533,11.1126835 8.59792137,10.3412062 C8.58803288,10.3315557 8.57824467,10.321803 8.5685583,10.3119497 Z M10,9.11401367 L17,2 L3,2 L10,9.11401367 Z" fill="#979797"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>

                <input type="email" id="email" name="email" class="login-form__input" placeholder="Email address" autocapitalize="off" v-on:focus="emailFocused = true" v-on:blur="emailFocused = false">
            </div>

            <div :class="{ 'login-form__input-container': true, 'login-form__input-container--focused': passwordFocused }">
                <div class="login-form__icon-container">
                    <svg width="16px" height="20px" viewBox="0 0 16 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-567.000000, -294.000000)" fill="#979797">
                                <g transform="translate(551.000000, 240.000000)">
                                    <g transform="translate(16.000000, 54.000000)">
                                        <path d="M2,6 C2,2.6862915 4.6862915,0 8,0 C11.3137085,0 14,2.6862915 14,6 L14,8 C15.1045695,8 16,8.8954305 16,10 L16,18 C16,19.1045695 15.1045695,20 14,20 L2,20 C0.8954305,20 0,19.1045695 0,18 L0,10 C0,8.8954305 0.8954305,8 2,8 L2,6 Z M2,10 L2,18 L14,18 L14,10 L2,10 Z M12,8 L12,6 C12,3.790861 10.209139,2 8,2 C5.790861,2 4,3.790861 4,6 L4,8 L12,8 Z M8,12 C8.55228475,12 9,12.4477153 9,13 L9,15 C9,15.5522847 8.55228475,16 8,16 C7.44771525,16 7,15.5522847 7,15 L7,13 C7,12.4477153 7.44771525,12 8,12 Z"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>

                <input type="password" id="password" name="password" class="login-form__input" placeholder="Password" v-on:focus="passwordFocused = true" v-on:blur="passwordFocused = false">
            </div>
        </div>

        <div v-if="errors" class="login_form__error">
            These credentials do not match our records.
        </div>

        <button type="submit" class="login-form__button">
            Log in
        </button>
    </form>
</template>

<script>
    export default {
        props: ['errors'],
        data: () => ({
            emailFocused: false,
            passwordFocused: false
        })
    }
</script>