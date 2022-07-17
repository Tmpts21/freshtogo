<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { deliveryFares } from '../Customer/Fares';

const form = useForm({
    name: '',
    email: '',
    city : '',
    barangay : '',
    streetAddress : '' ,
    postalCode : '' ,
    password: '',
    password_confirmation: '',
    contactNo : '', 
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Register" />

        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <BreezeLabel for="name" value="Name" />
                <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="email" value="Email" />
                <BreezeInput  type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
            </div>

            <BreezeLabel for="email" value="City" class="mt-2 mb-2 " />
             <select v-model="form.city" class="mt-1 mb-1 block appearance-none w-full  rounded border border-gray-400 hover:border-gray-500 px-2 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                   <option  value='Choose your City' selected>Choose your City </option>
                   <option v-for="fare in deliveryFares" :key="fare.id" >{{fare.city}}</option>
            </select>

              <div class="mt-4">
                <BreezeLabel for="email" value="Barangay" />
                <BreezeInput  type="text" class="mt-1 block w-full" v-model="form.barangay" required autocomplete="username" />
            </div>

              <div class="mt-4">
                <BreezeLabel for="email" value="Street Address" />
                <BreezeInput  type="text" class="mt-1 block w-full" v-model="form.streetAddress" required autocomplete="username" />
            </div>

              <div class="mt-4">
                <BreezeLabel for="email" value="Postal Code " />
                <BreezeInput type="text" class="mt-1 block w-full" v-model="form.postalCode" required autocomplete="username" />
            </div>

             <div class="mt-4">
                <BreezeLabel for="contact" value="Mobile Number" />
                <BreezeInput type="text" class="mt-1 block w-full" v-model="form.contactNo" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="password" value="Password" />
                <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="password_confirmation" value="Confirm Password" />
                <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <Link :href="route('login')" class="underline text-md font-bold text-gray-600 hover:text-gray-900">
                    Already registered? 🤔
                </Link>

                <BreezeButton class="ml-4 bg-orange-500" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
