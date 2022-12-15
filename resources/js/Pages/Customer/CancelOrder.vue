<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head , Link} from '@inertiajs/inertia-vue3';
    import { Inertia } from '@inertiajs/inertia'

    
    export default { 
        props : ['orderId' , 'orderStatus'] ,
        components : { 
            BreezeAuthenticatedLayout , 
            Head ,Link 
        } ,
        data () { 
            return { 
                reason : ''
               
            }
        }, 
        mounted() { 
        },
        methods :  {
            cancelOrder() { 
                    Inertia.post('/customer/cancel_order/' + this.orderId + '/' + this.reason  )
            } 
        }
    }
    </script>
    
    <template>
        <Head title="Dashboard" />
    
        <BreezeAuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Order Details  
                </h2>
            </template>
    
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
    
                            <div  class="overflow-x-auto relative">
                                <!-- component -->

                                <div class="flex justify-center">
                                    <div class="mb-3 xl:w-96">
                                        
                                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                            <span class="block sm:inline">Are you sure you want to cancel this order ? </span>
                                        </div>
                                        <label v-if="this.orderStatus == 'assigned' " for="exampleFormControlTextarea1" class="font-bold form-label inline-block mb-2 text-gray-700"
                                        >Please state the reason  🤔</label
                                        >

                                        <textarea v-model="reason" v-if="this.orderStatus == 'assigned' "
                                        required
                                        class="
                                            form-control
                                            block
                                            w-full
                                            px-3
                                            py-1.5
                                            text-base
                                            font-normal
                                            text-gray-700
                                            bg-white bg-clip-padding
                                            border border-solid border-gray-300
                                            rounded
                                            transition
                                            ease-in-out
                                            m-0
                                            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
                                        "
                                        id="exampleFormControlTextarea1"
                                        rows="3"
                                        placeholder="Your message"
                                        ></textarea>
                                        <div>
                                            <button @click="cancelOrder()"  type="submit" class=" float-right mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5  mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 font-bold">Cancel 📁</button>
                                        </div>
                                    </div>
                                   
                                    </div>
                                    


  
                            </div>

    
                        </div>
                    </div>
                </div>
            </div>
        </BreezeAuthenticatedLayout>
    </template>
    