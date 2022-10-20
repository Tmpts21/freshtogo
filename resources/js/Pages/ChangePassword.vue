<script >
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head ,Link  } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'
import { deliveryFares } from './Customer/Fares'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';



export default {
  components : {  
    BreezeAuthenticatedLayout ,
    Head ,
    Link
  },
  props :['errors'] ,

  setup (props) {
    const form = reactive({
        old : '',
        new : '' , 
        confirm: '',
    })


    function submit() { 
         Inertia.post('/profile/update/creds', form)
    }

    return { form , submit , deliveryFares}
  },
}
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Change Password
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


                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                    Old Password
                                </label>
                                <input v-model="form.old" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="password" placeholder="Enter password" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                    New Password
                                </label>
                                <input v-model="form.new" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="password" placeholder="Enter password" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                    Confirm Password 
                                </label>
                                <input v-model="form.confirm" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="password" placeholder="Enter password" required>
                            </div>

                            <button :disabled="form.processing" type="submit" class="float-right text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 font-bold">Update 📁</button>

                        </form>


               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
