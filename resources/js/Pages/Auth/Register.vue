<script >
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { deliveryFares } from '../Customer/Fares';
import { ref } from 'vue'


import address  from '../address.json' ; 


export default {
    components: {
        BreezeValidationErrors,
        BreezeLabel,
        BreezeInput,
        BreezeGuestLayout,
        BreezeButton,
        Head,
        Link
    },

    setup(){ 
        const form = useForm({
            firstName: '',
            middleName : '',
            lastName : '',
            email: '',
            city : '',
            barangay : '',
            streetAddress : '' ,
            postalCode : '' ,
            password: '',
            password_confirmation: '',
            contactNo : '', 
            terms: false,
            barangays : []
        });


        const submit = () => {
            form.post(route('register'), {
                onFinish: () => form.reset('password', 'password_confirmation'),
            });
        };

        let barangays = ref()
        const onChangeSelect = (event) => { 
            barangays.value = address[event.target.value]
        }

        return {submit , onChangeSelect , barangays , form , deliveryFares}

        }
    
}
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Register" />

        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit">

            <div class="mt-4">
                <BreezeLabel for="firstName" value="First Name" />
                <BreezeInput id="firstName" type="text" class="mt-1 block w-full" v-model="form.firstName" required autofocus autocomplete="First Name" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="middleName" value="Middle Name " />
                <BreezeInput id="middleName" type="text" class="mt-1 block w-full" v-model="form.middleName" required autofocus autocomplete="Middle Name" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="lastName" value="Last Name" />
                <BreezeInput id="lastName" type="text" class="mt-1 block w-full" v-model="form.lastName" required autofocus autocomplete="Last Name " />
            </div>

            <div class="mt-4">
                <BreezeLabel for="email" value="Email" />
                <BreezeInput  type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
            </div>

            <BreezeLabel for="email" value="City" class="mt-2 mb-2 " />
             <select @change="onChangeSelect" v-model="form.city" class="mt-1 mb-1 block appearance-none w-full  rounded border border-gray-400 hover:border-gray-500 px-2 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                   <option  value='Choose your City' selected>Choose your City </option>
                   <option v-for="fare in deliveryFares" :key="fare.id" >{{fare.city}}</option>
            </select>


            <div v-if="barangays">
                <BreezeLabel for="barangay" value="Barangay" class="mt-2 mb-2 " />
                <select id="barangay"  v-model="form.barangay" class="mt-1 mb-1 block appearance-none w-full text-black  rounded border border-gray-400 hover:border-gray-500 px-2 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option v-for="barangay in barangays" :key="barangay.id" >{{barangay}}</option>
                </select> 

                <div class="mt-4">
                <BreezeLabel for="email" value="Street Address" />
                <BreezeInput  type="text" class="mt-1 block w-full" v-model="form.streetAddress" required autocomplete="username" />
                 </div>
            </div>
        

           

              <div class="mt-4">
                <BreezeLabel for="email" value="Postal Code " />
                <BreezeInput type="number" class="mt-1 block w-full" v-model="form.postalCode" required autocomplete="username" />
            </div>

             <div class="mt-4">
                <BreezeLabel for="contact" value="Mobile Number" />
                <BreezeInput type="number" class="mt-1 block w-full" v-model="form.contactNo" required autocomplete="username" />
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

                <BreezeButton class="ml-4 bg-lime-500" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>

</template>

<style>

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    display: none;
}
</style>


