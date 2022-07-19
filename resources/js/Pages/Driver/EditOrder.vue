<script >
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head , Link } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'

export default {
   props: ['order'] ,  
  components : {  
    BreezeAuthenticatedLayout ,
    Head ,
    Link 
  },
  setup (props) {
  },
}
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">

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

                            <div v-if="order.image">
                                <div class="hero container max-w-screen-lg mx-auto pb-10">
                                    <img class="mx-auto border border-2 " :src="'/storage/' + order.image" width="200" height="200" alt="screenshot" >
                                </div>
                            </div>

                            <div v-else>
                                <h5 class="text-red-500">Image unavailable for this product ! </h5>
                            </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                    Customer Name
                                </label>
                                <input  readonly :value="order.customer_name" class="bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Product Name">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                    Customer Address
                                </label>
                                <input  readonly :value="order.address" class="bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Product Name">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                    Product Name
                                </label>
                                <input  readonly :value="order.product_name" class="bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Product Name">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                    Quantity
                                </label>
                                <input  readonly :value="order.quantity" class="bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Product Name">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                    Delivery Fee (₱)
                                </label>
                                <input  readonly :value="order.deliveryFee" class="bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Product Name">
                            </div>

                             <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                    Total Price (₱)
                                </label>
                                <input  readonly :value="order.total_price" class="bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Product Name">
                            </div>

                             <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                    Mode of Payment
                                </label>
                                <input  readonly :value="order.mop" class="bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Product Name">
                            </div>

                            <Link :href="route('driver.edit_order' , {id : order.id })"  class="float-right font-bold text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800"  v-html="'Update Status 📝 '" />
                           
                        </form>
               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
