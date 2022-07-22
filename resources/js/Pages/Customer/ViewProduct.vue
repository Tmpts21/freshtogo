<script >
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head , Link } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'

export default {
   props: ['product','categories' ,'errors' , 'feedbacks'] ,  
  components : {  
    BreezeAuthenticatedLayout ,
    Head ,
    Link 
  },
  setup (props) {
    console.log(props);
  },
}
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{product.name}}
            </h2>
        </template>


        <div class="py-12">
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

                        <div v-if="feedbacks.length > 0">
                        <h3 class="font-bold"> Reviews/Feedback </h3>
                            <div v-for="feedback in feedbacks" :key="feedback.key" class="max-w-md w-full lg:flex mb-4 " >
                                <div class="border border-2 rounded border-gray-300 p-4 flex flex-col justify-between leading-normal">
                                    <div class="mb-4">
                                    <div class="text-black font-bold text-xl">{{feedback.user_name}} </div>

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
                            <div class="mt-5 mb-5 rounded flex items-center bg-orange-500 text-white text-sm font-bold px-5 py-3" role="alert">
                                <p>No Reviews/Feedback availble for this product <span class="ml-2 text-lg"> 😭</span> </p>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
