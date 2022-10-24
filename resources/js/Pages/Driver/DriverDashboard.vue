<script >
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head , Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios'

import moment from 'moment'
export default { 
    props : ['orders'] ,
    components : { 
        BreezeAuthenticatedLayout ,
        Head,
        Link
    },
    data() { 
        return { 
            status : 'assigned' ,
            displayOrders : true , 
            listOfOrders : this.orders, 
            dispMessage : false , 
            message : '' ,
            position : null , 
        }
    },
    mounted () {
        this.onChangeSelect();
        if(navigator.geolocation) { 
            navigator.geolocation.getCurrentPosition(position => { 
                this.position = position.coords; 
                this.updateDriverLocation(); 
                setInterval(() => { 
                    // update drivers lat lon for admin monitoring  
                } , 10000 )
            })
        }
    },
    methods : { 

        updateDriverLocation() { 

            return axios.post('/driver/updateDriverPosition' , {
                'lat' : this.position.latitude ,
                'lon' : this.position.longitude ,
            }).then(response => (console.log(response)))
            
        },
        
        diffForHumans(date) { 
            return moment(date).fromNow(); 
        } ,

        displayMessage(message) { 
            this.dispMessage = true ;
            return this.message = message ; 
        },

        onChangeSelect() { 
            if (this.status === 'all') { 
                return this.listOfOrders = this.orders 
                
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
            <h2 class="font-semibold text-xl text-gray-800 ">
                My Deliveries  🚚
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">


                        <div class="inline-block relative w-64 mb-5     ">

                            <select v-model="status" @change="onChangeSelect()" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="assigned"  >Assigned</option>
                                        <option value="pending">Pending</option>
                                        <option value="delivered">Delivered</option>
                                        <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div v-if="displayOrders" class="overflow-x-auto relative">

                            <table class="text-center w-full text-sm text-left text-gray-500 dark:text-gray-800 border ">
                                <thead class="font-bold text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Order Id
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Customer Name 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Address
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                         No.of Products 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                         Assigned driver 
                                    </th>
                                     <th scope="col" class="px-6 py-3">
                                        Shipment Status 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Payment Status 
                                    </th>
                                    <th scope="co l" class="px-6 py-3">
                                        Date 
                                    </th>
                                     <th scope="col" class="px-6 py-3">
                                        Action 
                                    </th>
                                    
                                    
                                </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="order in listOfOrders" :key="order.id" class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                         <td class="px-2 py-1 border border-2 " >
                                        {{order.unique_id}}
                                    </td>
                                     <td class="px-2 py-1 border border-2 " >
                                        {{order.customer_name}}
                                    </td>
                                     <td class="px-2 py-1 border border-2 " >
                                        {{order.address}}
                                    </td>

                                    <td class="px-2 py-1 border border-2 " >
                                        {{order.total}}
                                    </td>
                               
                                     <td class="px-2 py-1 border border-2" >
                                        <span v-if="order.driver_name">
                                            {{order.driver_name}}
                                        </span>
                                        <span v-else> No assigned Driver </span>
                                    </td>
                                    <td class="px-2 py-1 border border-2 " >
                                        {{order.status}} 
                                    </td>
                                    <td class="px-2 py-1 border border-2 " >
                                        {{order.payment_status}} 
                                    </td>

                                    <td class="px-2 py-1 border border-2" >
                                        {{diffForHumans(order.created_at)}} 
                                    </td>

                                    <td v-if="order.status == 'pending' || order.status == 'assigned'" class="px-2 py-4 border border-2 " >
                                           <Link :href="route('driver.view_orders' , {id : order.id , status : order.status })"  class="font-bold text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mr-2 "  v-html="'View'" />
                                           <Link :href="route('driver.edit_order' , {id : order.id })"  class="font-bold text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800"  v-html="'Update'" />
                                           <a   class="mt-5 float-right font-bold text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800" target="_blank" :href="'https://www.google.com/maps/dir/?api=1&origin=current+location&destination=' + this.orders[0].address"> 🗺 maps </a>

                                        </td>
                                    <td v-else-if="order.status == 'delivered'" class="px-2 py-4 border border-2 " >
                                           <Link :href="route('driver.view_orders' , {id : order.id , status : order.status })"  class="font-bold text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mr-2 "  v-html="'View'" />
                                           <a   class="mt-5 float-right font-bold text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800" target="_blank" :href="'https://www.google.com/maps/dir/?api=1&origin=current+location&destination=' + this.orders[0].address"> 🗺 maps </a>

                                        </td>

                                     <td v-else class="px-2 py-4 border border-2 " >
                                        <Link :href="route('driver.view_orders' , {id : order.id , status : order.status })"  class="font-bold text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mr-2 "  v-html="'View'" />
                                        <a   class="mt-5 float-right font-bold text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800" target="_blank" :href="'https://www.google.com/maps/dir/?api=1&origin=current+location&destination=' + this.orders[0].address"> 🗺 maps </a>
                                    </td>
                                    

                                </tr>
                        
                                </tbody>
                            </table>

                        </div>

                        <div v-else >
                            <div class="mb-5 rounded flex items-center bg-orange-500 text-white text-sm font-bold px-5 py-3" role="alert">
                                <p>No available deliveries<span class="ml-2 text-lg"> 🤷‍♂️</span> </p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
