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

        
 <nav class="bg-lime-400 shadow shadow-lg ">
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

                                      <BreezeNavLink class="font-bold text-white " :href="route('guest.feedback')" :active="route().current('guest.feedback')">
                                    ⭐  Reviews/Feedback 
                                    </BreezeNavLink>

                                      <BreezeNavLink class="font-bold text-white " :href="route('guest.contact')" :active="route().current('contact')">
                                      🤙  Contact us 
                                    </BreezeNavLink>
                            </div>
                            


                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">

                            
                            <button class="bg-lime-500 hover:bg-lime-700 text-white font-bold py-2 px-4 border border-lime-700 rounded">

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
                        <BreezeResponsiveNavLink class="text-lime-500 font-bold" :href="route('register')" :active="route().current('register')">
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
                                    <p class="text-grey-darker text-base">"{{feedback.feedback}}"</p>
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
                            <div class="mt-5 mb-5 rounded flex items-center bg-lime-500 text-white text-sm font-bold px-5 py-3" role="alert">
                                <p>No Reviews/Feedback availble for this product <span class="ml-2 text-lg"> 😭</span> </p>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <footer class="p-4 bg-lime-500 text-white sm:p-6 dark:bg-lime-900">
    <div class="md:flex md:justify-between ">
        <div class="mb-6 md:mb-0">
            <a href="https://flowbite.com/" class="flex items-center">
                <BreezeApplicationLogo class="block h-9 w-auto mr-4 " />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">FreshToGo</span>
            </a>
        </div>
        <div class="grid grid-cols-3 gap-36 sm:gap-6 sm:grid-cols-3 text-white">
            <div>
                <h2 class="mb-6 text-sm font-semibold text-white uppercase dark:text-white">Contact us</h2>
                <ul class="text-white dark:text-gray-400">
                    <li class="mb-4">
                        <a href="#" class="hover:underline">Email 📧:  freshtogo21@gmail.com</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="hover:underline">Telephone 📞 : (02)123 456 </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="hover:underline">Mobile No 📲 : 0912345678  </a>
                    </li>
                </ul>
            </div>
            <div class="text-white ml-32 ">
                <h2 class="mb-6 text-sm font-semibold text-white uppercase dark:text-white">Follow us</h2>
                <ul class="text-white dark:text-gray-400">
                    <li class="mb-4">
                        <a href="https://github.com/themesberg/flowbite" class="hover:underline "><i class="fa-brands fa-facebook mr-2"></i> Facebook</a>
                    </li>
                    <li class="mb-4">
                        <a href="https://discord.gg/4eeurUVvTy" class="hover:underline"><i class="fa-brands fa-twitter mr-2"></i> Twitter</a>
                    </li>
                    <li>
                        <a href="https://discord.gg/4eeurUVvTy" class="hover:underline"><i class="fa-brands fa-instagram mr-2"></i> Instagram</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr class="my-6 border-gray-200 text-white sm:mx-auto dark:border-gray-700 lg:my-8">
    <div class="sm:flex sm:items-center text-white sm:justify-between">
        <span class="text-sm text-white sm:text-center dark:text-gray-400">© 2022 <a href="https://flowbite.com/" class="hover:underline">FreshToGo™</a>. All Rights Reserved.
        </span>
        <div class="flex mt-4 space-x-6 sm:justify-center sm:mt-0">
            <a href="#" class="text-white hover:text-gray-900 dark:hover:text-white">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Facebook page</span>
            </a>
            <a href="#" class="text-white hover:text-gray-900 dark:hover:text-white">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Instagram page</span>
            </a>
            <a href="#" class="text-white hover:text-gray-900 dark:hover:text-white">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path></svg>
                <span class="sr-only">Twitter page</span>
            </a>
            <a href="#" class="text-white hover:text-gray-900 dark:hover:text-white">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">GitHub account</span>
            </a>
            <a href="#" class="text-white hover:text-gray-900 dark:hover:text-white">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Dribbbel account</span>
            </a>
        </div>
    </div>
</footer>
</template>
