<script >
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head ,Link  } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'
import { deliveryFares } from './Customer/Fares'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import address from "./address.json"
import { ref } from 'vue'



export default {
  components : {  
    BreezeAuthenticatedLayout ,
    Head ,
    Link
  },
  props :['errors'] ,

  setup (props) {
    const form = reactive({
      firstName :usePage().props.value.auth.user.firstName,
      middleName : usePage().props.value.auth.user.middleName,
      lastName : usePage().props.value.auth.user.lastName,
      email: usePage().props.value.auth.user.email,
      city : usePage().props.value.auth.user.city,
      barangay : usePage().props.value.auth.user.barangay,
      street_address : usePage().props.value.auth.user.street_address,
      postal_code : usePage().props.value.auth.user.postal_code,
      contact_no :usePage().props.value.auth.user.contact_no,
      image :usePage().props.value.auth.user.image,
    })

    function submit() { 
         Inertia.post('/profile/update', form)
    }
    
    let barangays = ref(); 
    const onChangeSelect = (event) => { 
            barangays.value = address[event.target.value]
        }

    return { form , submit , deliveryFares , barangays , onChangeSelect}
  },
}
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My profile
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 flex flex-col justify-center items-center">
                           <div v-if="$page.props.flash.success" class="alert">
                                <div class="bg-green-100 text-green-700 p-4" role="alert">
                                    <p>{{ $page.props.flash.success }}</p>
                                </div>
                                <br>
                            </div>

                            <div v-if="$page.props.flash.error" class="alert">
                                <div class="bg-red-100 text-red-700 p-4" role="alert">
                                    <p>{{ $page.props.flash.error }}</p>
                                </div>
                                <br>
                            </div>

                            <div v-if="errors">
                                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                    <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
                                </ul>
                            </div>


                        <div class="w-full max-w-xs">


                        <form @submit.prevent="submit()"  class="bg-white rounded px-8 pt-6 pb-8 mb-4">

                        <div v-if="form.image" class="flex flex-wrap justify-center mb-5 ">
                                <img :src="'/storage/' + $page.props.auth.user.image " width="250" height="250" alt="..." class="shadow rounded-full max-w-full h-auto align-middle border-none" />
                        </div>

                        <div v-else >
                            <div class="mb-5 rounded flex items-center bg-lime-500 text-white text-sm font-bold px-4 py-3" role="alert">
                                <p>Profile picture not available 🙁  </p>
                            </div>
                        </div>

                         <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Update profile picture
                            </label>
                        </div>  
                         <input type="file" class="mb-10" @input="form.image = $event.target.files[0]" />
                                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                        </progress>


                        


                             <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                First Name
                            </label>
                            <input v-model="form.firstName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Enter First Name">
                            </div>

                            <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Middle Name 
                            </label>
                            <input v-model="form.middleName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Enter Middle Name">
                            </div>

                            <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Last Name 
                            </label>
                            <input v-model="form.lastName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Enter Last Name">
                            </div>

                            <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Email
                            </label>
                            <input v-model="form.email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="email" placeholder="Enter Name">
                            </div>

                            <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                City
                            </label>
                            <select @change="onChangeSelect"  v-model="form.city" class="mt-1 mb-1 block appearance-none w-full  rounded border border-gray-400 hover:border-gray-500 px-2 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                <option  value='Choose your City' selected>Choose your City </option>
                                <option v-for="fare in deliveryFares" :key="fare.id" >{{fare.city}}</option>
                            </select>
                            </div>

                            <div v-if="barangays">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="barangay">
                                    Barangay
                                </label>
                                <select id="barangay"  v-model="form.barangay" class="mt-1 mb-1 block appearance-none w-full text-black  rounded border border-gray-400 hover:border-gray-500 px-2 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                <option v-for="barangay in barangays" :key="barangay.id" >{{barangay}}</option>
                                </select> 

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                        Street Address  
                                    </label>
                                    <input v-model="form.street_address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Enter Street Address ">
                                </div>
                            </div>

                            <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Postal Code
                            </label>
                            <input v-model="form.postal_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="number" placeholder="Enter Postal Code ">
                            </div>

                            <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Mobile Number
                            </label>
                            <input v-model="form.contact_no" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="number" placeholder="Enter Mobile number ">
                            </div>

                            

                            <button :disabled="form.processing" type="submit" class="float-right text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 font-bold">Save 📁</button>

                        </form>

                        <Link :href="route('change.password')" class="font-bold text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-orange-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-orange-800 float-right" v-html="'Change password'" />

               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style>

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    display: none;
}
</style>
