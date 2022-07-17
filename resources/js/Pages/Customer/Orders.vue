<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import moment from 'moment' 

export default { 
    props : ['orders'] , 
    components : { Head , BreezeAuthenticatedLayout},
    data() { 
        return { 
            status : 'pending' , 
            listOfOrders : this.orders 
        }
    }, 
    mounted() { 
        this.onChangeSelect();
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
                            <option value="assigned"  >Assigned</option>
                            <option value="delivered"  >Delivered</option>
                            <option value="cancelled"  >Cancelled</option>
                        </select>
                            </div>

                            <table class="mt-5 text-center w-full text-sm text-left text-gray-500 dark:text-gray-800 border mx-auto ">
                                <thead class="font-bold text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Order Id
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                         Product Name 
                                    </th>
                                     <th scope="col" class="px-6 py-3">
                                         Total Price 
                                    </th>
                                     <th scope="col" class="px-6 py-3">
                                        Delivery Fee  
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
                                    
                                </tr>
                                </thead>

                                <tbody class="mx-auto">
                                    <tr v-for="order in listOfOrders" :key="order.id" class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                    <td class="px-2 py-1 border border-2" >
                                        FTG-{{order.id}}
                                    </td>
                                    <td class="px-2 py-1 mx-auto border border-2 " >
                                        {{order.product_name}}
                                        <!-- <img :src="'/storage/' + product.image" height="150" width="150" alt=""> -->
                                    </td>
                                     <td class="px-2 py-1 border border-2 " >
                                       ₱  {{order.total_price}}
                                    </td>
                                    <td class="px-2 py-1 border border-2 " >
                                       ₱  {{order.deliveryFee}}
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

                                </tr>
                        
                                </tbody>
                            </table>
                        </div>








                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
