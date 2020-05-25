<template>
    <v-stepper v-model="stepperPosition" class="col-12 col-md-10 col-lg-8">
        <v-stepper-header>
            <v-stepper-step :complete="stepperPosition > 1" step="1"
                >Welcome</v-stepper-step
            >

            <v-divider></v-divider>

            <v-stepper-step :complete="stepperPosition > 2" step="2"
                >Minecraft Account Link</v-stepper-step
            >

            <v-divider></v-divider>

            <v-stepper-step :complete="stepperPosition > 3" step="3"
                >Discord Account Link</v-stepper-step
            >

            <v-divider></v-divider>

            <v-stepper-step step="4">Complete Registration</v-stepper-step>
        </v-stepper-header>

        <v-stepper-items>
            <!-- Welcome Page -->
            <v-stepper-content step="1">
                <div class="text-center">
                    <h1>Registration Form</h1>
                    <span
                        >Please follow the registration steps to gain access to
                        the panel</span
                    >
                </div>

                <v-btn
                    color="primary"
                    @click="stepperPosition = 2"
                    style="float: right;"
                >
                    Continue
                </v-btn>
            </v-stepper-content>

            <!-- Minecraft Verification Page -->
            <v-stepper-content step="2">
                <div class="text-center">
                    <h1>Minecraft Account Link</h1>
                    <span
                        >To access the site, you need to link your minecraft
                        account. To link your account you need to login to
                        <code>{{ ip }}</code> and type
                        <code>/panel link</code></span
                    >
                    <div class="input-wrapper">
                        <v-col v-if="!mc.valid">
                            <br />
                            <PincodeInput v-model="mc.code" />
                            <br />
                            <v-btn
                                :loading="mc.loading"
                                :disabled="mc.loading || mc.valid"
                                class="ma-2"
                                color="primary"
                                @click="checkCode()"
                            >
                                Verify Account
                            </v-btn>
                            <br />
                        </v-col>
                    </div>
                    <v-col cols="12">
                        <v-row align="center" justify="center">
                            <OnboardingCard
                                :visible="mc.valid"
                                :title="mc.username"
                                :imgUrl="
                                    `https://visage.surgeplay.com/bust/128/${mc.uuid}.png`
                                "
                            ></OnboardingCard>
                        </v-row>
                    </v-col>
                </div>
                <div style="float: right;">
                    <v-btn
                        color="primary"
                        @click="stepperPosition = 3"
                        :disabled="!mc.valid"
                    >
                        Continue
                    </v-btn>

                    <v-btn @click="stepperPosition = 1" text>Cancel</v-btn>
                </div>
            </v-stepper-content>

            <!-- Discord Verification Page -->
            <v-stepper-content step="3">
                <div class="text-center">
                    <h1>Discord Account Link</h1>
                    <span
                        >To access the site, you need to link your discord
                        account. To link your account you need to login to
                        Discord using the button below</span
                    >
                    <div class="input-wrapper">
                        <v-col v-if="!discord.valid">
                            <v-btn
                                :loading="discord.loading"
                                :disabled="discord.loading"
                                class="ma-2"
                                color="#7289DA"
                                @click="verifyDiscord()"
                            >
                                Login with Discord
                            </v-btn>
                            <br />
                        </v-col>
                    </div>
                    <v-col cols="12">
                        <v-row align="center" justify="center">
                            <OnboardingCard
                                :visible="discord.valid"
                                :title="discord.username"
                                :imgUrl="discord.avatar"
                            ></OnboardingCard>
                        </v-row>
                    </v-col>
                </div>
                <div style="float: right;">
                    <v-btn
                        color="primary"
                        @click="stepperPosition = 4"
                        :disabled="!discord.valid"
                    >
                        Continue
                    </v-btn>

                    <v-btn @click="stepperPosition = 2" text>Cancel</v-btn>
                </div>
            </v-stepper-content>

            <!-- Final Registration Page -->
            <v-stepper-content step="4">
                <div class="text-center">
                    <h1>Complete Registration</h1>
                    <span
                        >Please fill in the form below to register for the
                        site.</span
                    >
                    <v-row align="center" justify="center">
                        <v-col cols="4">
                            <OnboardingCard
                                :visible="discord.valid"
                                :title="discord.username"
                                :imgUrl="discord.avatar"
                            ></OnboardingCard>
                            <br />
                            <OnboardingCard
                                :visible="mc.valid"
                                :title="mc.username"
                                :imgUrl="
                                    `https://visage.surgeplay.com/bust/128/${mc.uuid}.png`
                                "
                            ></OnboardingCard>
                        </v-col>
                        <v-col cols="6">
                            <v-form ref="form">
                                <v-text-field
                                    label="Username"
                                    v-model="registration.username"
                                    disabled
                                    required
                                ></v-text-field>
                                <v-text-field
                                    label="Email Address"
                                    v-model="registration.email"
                                    :rules="emailRules"
                                    required
                                ></v-text-field>
                                <v-text-field
                                    label="Password"
                                    v-model="registration.password"
                                    :rules="passwordRules"
                                    type="password"
                                    required
                                ></v-text-field>
                                <v-text-field
                                    label="Confirm Password"
                                    v-model="registration.password_confirm"
                                    :rules="passwordRules"
                                    type="password"
                                    required
                                ></v-text-field>
                                <div style="float: right;">
                                    <v-btn color="primary" @click="completeRegistration">
                                        Complete Registration
                                    </v-btn>
                                </div>
                            </v-form>
                        </v-col>
                    </v-row>
                </div>
                <div style="float: right;">
                    <v-btn @click="stepperPosition = 3" text>Cancel</v-btn>
                </div>
            </v-stepper-content>
        </v-stepper-items>
    </v-stepper>
</template>

<script>
import OnboardingCard from "./OnboardingCard.vue";
import PincodeInput from "vue-pincode-input";
const axios = require("axios").default;
axios.defaults.headers.common["X-CSRF-TOKEN"] = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

export default {
    name: "OnboardingStepper",
    components: {
        PincodeInput
    },
    props: {
        onboarding_id: null,
        onboarding_mc_uuid: null,
        onboarding_discord_id: null
    },
    data() {
        return {
            stepperPosition: 1,
            mcBoxNumber: 0,
            ip: process.env.MIX_MINECRAFT_LINK_IP,
            mc: {
                loading: false,
                code: "",
                valid: false,
                error: null,
                username: null,
                uuid: null
            },
            discord: {
                loading: false,
                valid: false,
                error: null,
                username: null,
                id: null,
                avatar: null
            },
            registration: {
                username: null,
                email: null,
                password: null,
                password_confirm: null,
                onboardingid: this.onboarding_id
            },
            emailRules: [
                v => !!v || "E-mail is required",
                v => /.+@.+\..+/.test(v) || "E-mail must be valid"
            ],
            passwordRules: [v => !!v || "Password is required"]
        };
    },
    methods: {
        checkCode: function() {
            var vm = this;
            vm.mc.loading = true;
            let service = axios.create({
                responseType: "json"
            });
            axios
                .post("/api/v1/auth/minecraft", { code: vm.mc.code })
                .then(function(response) {
                    if (response.data.isValid != true) {
                        vm.$toast.error(response.data.error);
                    } else {
                        axios
                            .post("/api/v1/onboarding/save/mc", {
                                key: vm.onboarding_id,
                                mc_uuid: response.data.uuid,
                                mc_username: response.data.username
                            })
                            .then(function(saveResponse) {
                                if (saveResponse.data.success == false) {
                                    vm.mc.error = saveResponse.data.error;
                                    vm.$toast.error(saveResponse.data.error);
                                } else {
                                    vm.$toast.success(
                                        "Minecraft Username Saved for Onboarding"
                                    );
                                    vm.mc.uuid = response.data.uuid;
                                    vm.mc.username = response.data.username;
                                    vm.mc.valid = response.data.isValid == true;
                                    vm.registration.username =
                                        response.data.username;
                                }
                            });
                    }
                    vm.mc.loading = false;
                });
        },
        verifyDiscord: function() {
            var vm = this;
            vm.discord.loading = true;
            const left = (screen.width - 500) / 2;
            const top = (screen.height - 850) / 4;
            let authWindow = window.open(
                "/api/v1/auth/discord",
                "Discord OAuth",
                `height=850,width=500,left=${left},top=${top}`
            );
            window.addEventListener("message", function(event) {
                const code = event.data;
                axios
                    .post("/api/v1/auth/discord/flow", { code: code })
                    .then(function(response) {
                        axios
                            .post("/api/v1/onboarding/save/discord", {
                                key: vm.onboarding_id,
                                discord_id: response.data.id,
                                discord_email: response.data.email
                            })
                            .then(function(saveResponse) {
                                if (saveResponse.data.success == false) {
                                    vm.discord.error = saveResponse.data.error;
                                    vm.$toast.error(saveResponse.data.error);
                                } else {
                                    vm.$toast.success(
                                        "Discord Username Saved for Onboarding"
                                    );
                                    vm.discord.valid = true;
                                    vm.discord.username =
                                        response.data.username;
                                    vm.discord.email = response.data.email;
                                    vm.discord.id = response.data.id;
                                    vm.discord.avatar = response.data.avatar;
                                    vm.registration.email = response.data.email;
                                }
                            });
                        vm.discord.loading = false;
                    });
            });
        },
        completeRegistration: function() {
            var vm = this;
            let service = axios.create({
                responseType: "json"
            });
            axios
                .post("/api/v1/onboarding/register", {
                    onboarding_id: vm.onboarding_id,
                    email: vm.registration.email,
                    password: vm.registration.password,
                    password_confirm: vm.registration.password_confirm
                })
                .then(function(saveResponse) {
                    if (saveResponse.data.success) {
                        console.log(saveResponse.data);
                    } else {
                        vm.$toast.error(saveResponse.data.error);
                    }
                });
        }
    }
};
</script>
<style>
.custom-loader {
    animation: loader 1s infinite;
    display: flex;
}
@-moz-keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
@-webkit-keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
@-o-keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
@keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
