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
                reason : '' ,
                otherReason : '' ,
                isOther : false
               
            }
        }, 
        mounted() { 
        },
        methods :  {
            cancelOrder() { 
                    if(this.isOther == true ) { 
                        this.reason = this.otherReason;
                        return Inertia.post('/customer/cancel_order/' + this.orderId + '/' + this.otherReason  )
                    }
                    return Inertia.post('/customer/cancel_order/' + this.orderId + '/' + this.reason  )
            },
            onChangeSelect(event) { 
                if (event.target.value === 'other') { 
                    this.isOther = true ;
                }
                else this.isOther = false ;

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
                                        <label for="exampleFormControlTextarea1" class="font-bold form-label inline-block mb-2 text-gray-700"
                                        >Please choose the reason  🤔</label
                                        >

                                      

                                        <div class="inline-block relative w-64">
                                        <select @change="onChangeSelect($event)" v-model="this.reason" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                            <option value="Product is taking too long to be delivered.">1.Product is taking too long to be delivered.</option>
                                            <option value="Customer discovered the same product on another website or a shop at a lower price than the order price.">2.Customer discovered the same product on another website or a shop at a lower price than the order price.</option>
                                            <option value="Customer changes his mind and opts for another brand instead.">3.Customer changes his mind and opts for another brand instead.</option>
                                            <option value="Customer has ordered it for someone else but the other person has it already or bought something else.">4.Customer has ordered it for someone else but the other person has it already or bought something else.</option>
                                            <option value="other">5.Others</option>
                                        </select>
                                    </div>

                                    <div v-if="this.isOther" for="exampleFormControlTextarea1" class="font-bold form-label inline-block mb-2 text-gray-700">
                                        <p class="font-bold mt-4 ">Other reason please specify</p>
                                    </div>
                                    <textarea v-model="this.otherReason" 
                                        v-if = "this.isOther" 
                                        required
                                        class="
                                            mt-2 
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
    