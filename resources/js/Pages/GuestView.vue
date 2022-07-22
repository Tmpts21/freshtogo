<script >
import { Head, Link } from '@inertiajs/inertia-vue3';
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import BreezeNavLink from '@/Components/NavLink.vue';
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { defineComponent } from '@vue/runtime-core';
import { ref } from 'vue';

export default {
   props: ['product','categories' ,'errors' , 'feedbacks'] ,  
  components : {  
    Head ,
    Link ,
    BreezeApplicationLogo,
    BreezeDropdown,
    BreezeDropdownLink,
    BreezeNavLink,
    BreezeResponsiveNavLink
  },
  setup (props) {
    console.log(props);
  },
}
</script>

<template>
    <Head title="Dashboard" />

        <template >
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{product.name}}
            </h2>
        </template>

        
 <nav class="bg-orange-400 shadow shadow-lg ">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex ">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('welcome')">
                                    <BreezeApplicationLogo class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex ">
                                    <BreezeNavLink class="font-bold text-white " :href="route('welcome')" :active="route().current('welcome')">
                                       🍖  Products 
                                    </BreezeNavLink>

                                      <BreezeNavLink class="font-bold text-white " :href="route('feedback')" :active="route().current('feedback')">
                                    ⭐  Reviews/Feedback 
                                    </BreezeNavLink>

                                      <BreezeNavLink class="font-bold text-white " :href="route('contact')" :active="route().current('contact')">
                                      🤙  Contact us 
                                    </BreezeNavLink>
                            </div>
                            


                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">

                            
                            <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 border border-orange-700 rounded">

                            <Link :href="route('register')" >
                                Register
                            </Link>

                           </button>

                            <BreezeNavLink class="font-bold text-md ml-2 text-white" :href="route('login')" :active="route().current('login')">
                                login 
                            </BreezeNavLink>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <BreezeResponsiveNavLink class="text-orange-500 font-bold" :href="route('register')" :active="route().current('register')">
                            Register
                        </BreezeResponsiveNavLink>

                         <BreezeResponsiveNavLink class="font-bold text-white" :href="route('login')" :active="route().current('login')">
                            Login
                        </BreezeResponsiveNavLink>
          
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="mt-3 space-y-1">
                            <BreezeResponsiveNavLink :href="route('welcome')" method="post" as="button">
                                products
                            </BreezeResponsiveNavLink>

                             <BreezeResponsiveNavLink :href="route('welcome')" method="post" as="button">
                                feedback
                            </BreezeResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>


        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 flex flex-col justify-center items-center">
                        <div class="w-full max-w-lg">


                        <form class="bg-white rounded px-8 pt-6 pb-8 mb-4">

                                <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Image
                            </label>

                            <div v-if="product.image">
                                <img :src="'/storage/' + product.image" height="200" width="200"  class="ml-32" alt="" >
                            </div>

                            <div v-else>
                                <h5 class="text-red-500">Image unavailable for this product ! </h5>
                            </div>
                            </div>

                            <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Product Name
                            </label>


                            <input  readonly :value="product.name" class="bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Product Name">
                            </div>

                                <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Category 
                            </label>



                                <input :value="categories[product.category_id - 1 ].name" readonly id="countries" class="bg-gray-200 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">


                            </div>

                                <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Brand
                            </label>


                            <input readonly :value="product.brand" class="bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Brand Name">
                            </div>

                                <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                stock(kg)
                            </label>

                            <input readonly :value="product.stock" class="bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Enter how many stock">
                            </div>

                            <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Price(kg)
                            </label>

                            <input readonly :value="'₱ ' + product.price" class="bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Enter product price">
                            </div>

                        </form>

                        <div v-if="feedbacks.length > 0 ">
                        <h3 class="font-bold"> Reviews/Feedback </h3>
                            <div v-for="feedback in feedbacks" :key="feedback.key" class="max-w-md w-full lg:flex mb-4 " >
                                <div class="border border-2 rounded border-gray-300 p-4 flex flex-col justify-between leading-normal">
                                    <div class="mb-4">
                                    <div class="text-black font-bold text-xl mb-2">{{feedback.user_name}}</div>
                                    <p class="text-grey-darker text-base">{{feedback.feedback}}</p>
                                    </div>
                                    <div class="flex">
                                        <div v-for="index in feedback.stars" :key="index" class="text-sm">
                                            ⭐
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>

                        <div v-else >
                            <div class="mt-5 mb-5 rounded flex items-center bg-orange-500 text-white text-sm font-bold px-5 py-3" role="alert">
                                <p>No Reviews/Feedback availble for this product <span class="ml-2 text-lg"> 😭</span> </p>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>
