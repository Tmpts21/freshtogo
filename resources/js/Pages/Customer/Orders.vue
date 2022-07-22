<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head , Link } from '@inertiajs/inertia-vue3';
import moment from 'moment' 

export default { 
    props : ['orders'] , 
    components : { Head , BreezeAuthenticatedLayout , Link },
    data() { 
        return { 
            status : 'pending' , 
            listOfOrders : this.orders,
            displayOrders : true ,
        }
    }, 
    mounted() { 
        this.onChangeSelect()
    },
    methods : { 
        diffForHumans(date ) { 
            return moment(date).fromNow();     // 4 years ago
        },

        onChangeSelect() { 
            if (this.status === 'all') { 
                this.listOfOrders = this.orders 
            }
            else { 
                 this.listOfOrders = this.orders 
                 this.listOfOrders = this.listOfOrders.filter((order) => { 
                    return order.status == this.status
                 })

                 if(this.listOfOrders.length == 0 )  this.displayOrders = false;
                 else this.displayOrders = true;
            }
        },
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My orders  
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">


                            <div class="relative overflow-x-auto sm:rounded-lg font-bold">

                            <div v-if="$page.props.flash.success" class="alert">
                                <div class="bg-green-100 text-green-700 p-4" role="alert">
                                    <p>{{ $page.props.flash.success }}</p>
                                </div>
                                <br>
                            </div>

                                <div class="inline-block relative w-64">

                            <select v-model="status" @change="onChangeSelect()" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            <option value="all" selected >All</option>
                            <option value="pending"  >Pending</option>
                            <option value="delivered"  >Delivered</option>
                            <option value="cancelled"  >Cancelled</option>
                        </select>
                            </div>

                    <div v-if="displayOrders" class="overflow-x-auto relative mb-5 ">

                            <table class="mt-5 text-center w-full text-sm text-left text-gray-500 dark:text-gray-800 border mx-auto ">
                                <thead class="font-bold text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                         Product Name 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                         Image 
                                    </th>
                                     <th scope="col" class="px-6 py-3">
                                         Total Price 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Quantity 
                                    </th>
                                     <th scope="col" class="px-6 py-3">
                                        status 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        date 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action 
                                    </th>
                                    
                                </tr>
                                </thead>

                                <tbody class="mx-auto">
                                    <tr v-for="order in listOfOrders" :key="order.id" class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                    <td class="px-2 py-1 mx-auto border border-2 " >
                                        {{order.product_name}}
                                        <!-- <img :src="'/storage/' + product.image" height="150" width="150" alt=""> -->
                                    </td>

                                    <td class="px-2 py-1 mx-auto border border-2 " >
                                        <img :src="'/storage/' + order.image " class="ml-5 w-20 h-20 rounded-full">
                                    </td>


                                     <td class="px-2 py-1 border border-2 " >
                                       ₱  {{order.total_price}}
                                    </td>
                                     <td class="px-2   py-1 border border-2 " >
                                        {{order.quantity}}
                                    </td>

                                    
                                    <td  class=" px-2 py-1 border border-2 " 
                                    :class="{
                                        'text-green-500' : order.status == 'delivered',
                                        'text-red-500' : order.status == 'cancelled',
                                        'text-orange-400' : order.status == 'pending',
                                        'text-blue-500' : order.status == 'assigned',
                                    }"
                                    >
                                        {{order.status}} 
                                    </td>
                                

                                    <td class="px-2 py-1 border border-2 " >
                                        {{diffForHumans(order.created_at)}} 
                                    </td>

                                    <td  v-if="order.status == 'delivered' && !order.is_feedback" class="px-2 py-1 border border-2 " >
                                           <Link :href="route('customer.feedback' , {id : order.product_id , orderId : order.id}) " class="font-bold text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800"  v-html="'➕ feedback '" />
                                    </td>
                                    <td v-else class="px-2 py-1 border border-2">
                                        N/A 
                                    </td>

                                </tr>
                        
                                </tbody>
                            </table>
                            </div>

                            <div v-else >
                                <div class="mb-5 mt-5 rounded flex items-center bg-orange-500 text-white text-sm font-bold px-5 py-3" role="alert">
                                    <p>No Orders available here <span class="ml-2 text-lg"> 😏 </span> </p>
                                </div>
                            </div>
                        </div>








                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
