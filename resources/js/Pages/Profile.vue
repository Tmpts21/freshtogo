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
     
        <div>

            

            <div class="mt-24 mb-24  bg-white relative shadow rounded-lg w-5/6 md:w-5/6  lg:w-4/6 xl:w-3/6 mx-auto">
                <div v-if="$page.props.flash.success" class="alert">
                                <div class="bg-green-100 font-bold text-green-700 p-4" role="alert">
                                    <p>{{ $page.props.flash.success }} 🎉</p>
                                </div>
                                <br>
                            </div>

                            <div v-if="$page.props.flash.error" class="alert">
                                <div class="bg-red-100 font-bold text-red-700 p-4" role="alert">
                                    <p>{{ $page.props.flash.error }}</p>
                                </div>
                                <br>
                            </div>
                
                <div class="flex justify-center">
                        <img v-if="$page.props.auth.user.image" :src="'/storage/'+ $page.props.auth.user.image" alt="" class="rounded-full mx-auto absolute -top-20 w-36 h-36 shadow-md border-4 border-white transition duration-200 transform hover:scale-110">
                </div>

                <div class="my-5 mt-24 px-24">
                        <Link :href="route('edit_profile') " class="font-bold text-gray-100 block rounded-lg text-center font-medium leading-6 px-6 py-3 bg-lime-500 hover:bg-lime-600 hover:text-white" v-html="'Edit Profile 🖊'" />
                </div>
                
                <div class="mt-16">
                    <h1 class="font-bold text-center text-3xl text-gray-900">{{$page.props.auth.user.name}}</h1>
                    <p class="text-center text-sm text-gray-400 font-medium">{{$page.props.auth.user.email}}</p>
                    <p>
                        <span>
                            
                        </span>
                    </p>


                    <div class="w-full">
                        <h3 class="font-bold text-gray-900 text-left px-6">Information 🔥</h3>
                        <div class="mt-5 w-full flex flex-col items-center overflow-hidden text-sm">
                            <p class="font-bold w-full border-t border-gray-100 text-gray-600 py-4 pl-6 pr-3 w-full block hover:bg-gray-100 transition duration-150">
                                    First Name :
                            <span class="text-gray-500 text-md"> {{$page.props.auth.user.firstName}}</span>
                            </p>

                            <p class="font-bold w-full border-t border-gray-100 text-gray-600 py-4 pl-6 pr-3 w-full block hover:bg-gray-100 transition duration-150">
                                    Middle Name :
                            <span class="text-gray-500 text-md"> {{$page.props.auth.user.middleName}}</span>
                            </p>

                            <p class="font-bold w-full border-t border-gray-100 text-gray-600 py-4 pl-6 pr-3 w-full block hover:bg-gray-100 transition duration-150">
                                    Last Name :
                            <span class="text-gray-500 text-md"> {{$page.props.auth.user.lastName}}</span>
                            </p>

                            <p class="font-bold w-full border-t border-gray-100 text-gray-600 py-4 pl-6 pr-3 w-full block hover:bg-gray-100 transition duration-150">
                                    Address :
                            <span class="text-gray-500 text-md"> {{$page.props.auth.user.street_address + ' ' + $page.props.auth.user.barangay + ' ' + $page.props.auth.user.city + ' ' + $page.props.auth.user.postal_code}}</span>
                            </p>

                            <p class="font-bold w-full border-t border-gray-100 text-gray-600 py-4 pl-6 pr-3 w-full block hover:bg-gray-100 transition duration-150">
                                    Contact Number :
                                    <span class="text-gray-500 text-md"> {{$page.props.auth.user.contact_no}} 📞</span>
                            </p>

                         
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>

  </BreezeAuthenticatedLayout>
</template>