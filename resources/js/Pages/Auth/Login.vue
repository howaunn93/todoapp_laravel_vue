<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <!-- <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                /> -->
                <v-text-field
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    label="Email"
                ></v-text-field>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-0">
                <!-- <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                /> -->

                <v-text-field
                    id="password"
                    type="password"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    label="Password"
                ></v-text-field>

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-0">
                <label class="flex items-center">
                    <!-- <Checkbox name="remember" v-model:checked="form.remember" /> -->
                    <v-checkbox label="Remember me" v-model:checked="form.remember"></v-checkbox>
                    <!-- <span class="ms-2 text-sm text-gray-600">Remember me</span> -->
                </label>
            </div>

            <div class="flex items-center justify-end mt-0">
                <!-- <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Forgot your password?
                </Link> -->

                <!-- <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton> -->
                <v-btn type="submit">
                    Log In
                </v-btn>
            </div>
        </form>
    </GuestLayout>
</template>
