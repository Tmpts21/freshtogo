<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head , Link} from '@inertiajs/inertia-vue3';
import moment from 'moment' 

export default { 
    props : ['orders'] ,
    components : { 
        BreezeAuthenticatedLayout , 
        Head ,Link 
    } ,
    data () { 
        return { 
            status : 'pending',
            listOfOrders : this.orders  
        }
    }, 
    mounted() { 
        this.onChangeSelect();
    },
    methods :  { 
        diffForHumans(date) { 
            return moment(date).fromNow(); 
        } ,
        onChangeSelect() { 
            console.log(this.orders); 
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
                Order Management 
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

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


                        <div  class="overflow-x-auto relative">


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
                                         Image 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                         Assigned driver 
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
                                    <td class="px-2 py-1 border border-2 " >
                                        FTG-{{order.id}}
                                    </td>
                                    <td class="px-2 py-1 mx-auto border border-2" >
                                        {{order.product_name}}
                                    </td>

                                     <td  class="mx-auto px-2 py-1 border border-2 "   >
                                        <img :src="'/storage/' + order.image " class="ml-10 w-20 h-20 rounded-full">
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

                                    <td class="px-2 py-1 border border-2" >
                                        {{diffForHumans(order.created_at)}} 
                                    </td>

                                    <td class="px-4 py-4 border border-2 " >
                                           <Link :href="route('order.edit' , {id : order.id })"  class="font-bold text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800"  v-html="'Update 📝'" />
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
