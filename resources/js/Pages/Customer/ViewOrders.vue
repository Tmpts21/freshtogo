<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head , Link} from '@inertiajs/inertia-vue3';
    import moment from 'moment' 
    
    export default { 
        props : ['orders' , 'totalPrice' ,'deliveryFee' ,'driver'] ,
        components : { 
            BreezeAuthenticatedLayout , 
            Head ,Link 
        } ,
        data () { 
            return { 
                listOfOrders : this.orders ,
                gcashInfo : Object.values(this.orders)[0],
            }
        }, 
        mounted() { 
        },
        methods :  { 
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
    
    <!-- component -->
<div class="max-w-xl mx-auto my-4 border-orange-400 border-b-2 pb-4">	
	<div class="flex pb-3">

        <div class="flex-1">
			<div :class="{'border-orange-400' : Object.values(this.orders)[0].status === 'pending'}" class="w-10 h-10 bg-white border-2 border-grey-light mx-auto rounded-full text-lg text-white flex items-center">
				<span class=" text-center w-full">📦</span>
			</div>
		</div>
	
		<div class="flex-1">
			<div :class="{'border-orange-400' : Object.values(this.orders)[0].status === 'assigned'}" class="w-10 h-10 bg-white border-2 border-grey-light mx-auto rounded-full text-lg text-white flex items-center">
				<span class=" text-center w-full">📬</span>
			</div>
		</div>
	

		<div class="flex-1">
			<div :class="{'border-orange-400' : Object.values(this.orders)[0].status === 'delivered'}"  class="w-10 h-10 bg-white border-2 border-grey-light mx-auto rounded-full text-lg text-white flex items-center">
				<span class="text-center w-full">🙌</span>
			</div>
		</div>
	
	</div>
	
	<div class="flex text-md text-center">
		
		<div class="flex-1 w-1/4 text-orange-400 font-bold">
			To Pay
		</div>
		<div class="flex-1 w-1/4 text-orange-400 font-bold">
			To Receive 
		</div>
		
		<div class="flex-1 w-1/4 text-orange-400 font-bold">
			Delivered
		</div>			
	</div>
</div>
                <div class="flex justify-center">
                    <a v-if="Object.values(this.orders)[0].status === 'assigned'" target="_blank"  :href="'https://www.google.com/maps/dir/?q=' + driver.lat + ',' + driver.lon"  class=" border boder-2 font-bold text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800"> 🗺 View Driver Location </a>
                </div>

    
                                <table class="mt-5 text-center w-full text-sm text-left text-gray-500 dark:text-gray-800 border mx-auto ">
                                    <thead class="font-bold text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Product Id
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Product Name 
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Image 
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                             Quantity 
                                        </th>
                                         <th scope="col" class="px-6 py-3">
                                            total Price 
                                        </th>
                                         <th scope="col" class="px-6 py-3">
                                            Mode of Payment  
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Assigned Driver 
                                        </th>
                                    
                                         <!-- <th scope="col" class="px-6 py-3">
                                            Action 
                                        </th> -->
                                        
                                    </tr>
                                    </thead>
    
                                    <tbody class="mx-auto">
                                        <tr v-for="order in listOfOrders" :key="order.id" class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                        <td class="px-2 py-1 border border-2 " >
                                            {{order.unique_id}}
                                        </td>
                                        <td class="px-2 py-1 border border-2 " >
                                            {{order.product_name}}
                                        </td>
                                        <td class="px-2 py-1 border border-2 " >
                                            <img :src="'/storage/' + order.image " class="ml-5 w-20 h-20 rounded-full">
                                        </td>
                                         <td class="px-2 py-1 border border-2 " >
                                            {{order.quantity}}
                                        </td>
    
                                        <td class="px-2 py-1 border border-2 " >
                                            ₱ {{order.total_price}}
                                        </td>
    
                                        <td class="px-2 py-1 border border-2 " >
                                             {{order.mop}}
                                        </td>
                                   
                                         <td class="px-2 py-1 border border-2" >
                                            <span v-if="order.driver_name">
                                                {{order.driver_name}}
                                            </span>
                                            <span v-else> No assigned Driver </span>
                                        </td>
    
    
    
                                        <!-- <td class="px-2 py-1 border border-2" >
                                            {{diffForHumans(order.created_at)}} 
                                        </td> -->
    <!-- 
                                        <td class="px-4 py-4 border border-2 " >
                                               <Link :href="route('order.view' , {id : order.id })"  class="font-bold text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mr-2 "  v-html="'View 👀'" />
                                               <Link :href="route('order.edit' , {id : order.id })"  class="font-bold text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800"  v-html="'Update 📝'" />
                                        </td> -->
    
                                    </tr>
    
                                          <tr>
    
                                        <td class="px-2 py-1" >
                                        </td>
    
                                        <td class="px-2 py-1" >
                                        </td>
    
                                        <td class="px-2 py-1" >
                                        </td>
                                        <td class="px-2 py-1" >
                                            
                                        </td>
                                          <td class="px-2 py-1 border border-2 font-bold " >
                                            Delivery fee :  ₱ {{deliveryFee}}
                                        </td>
                                         <td class="px-2 py-1 border border-2 font-bold " >
                                            Total : ₱ {{totalPrice}}
                                        </td>
                                        <td class="px-2 py-1" >
                                            
                                        </td>
                                       
                                       
                                       
    
                                      
                                    </tr>
                            
                                    </tbody>
                                </table>
                                <br><br>
    
                                <div v-if="gcashInfo.mop === 'Gcash'" class="p-6 flex flex-col justify-center items-center" >
                                    <div class="w-full max-w-lg">
                                        <form class="bg-white rounded px-8 pt-6 pb-8 mb-4">
    
    
                                            <div class="mb-4">
                                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                                    Proof of Payment
                                                </label>
    
                                                    <img :src="'/storage/' + gcashInfo.gcash_proof_of_payment" height="500" width="200"  class="ml-32" alt="" >
                                            </div>
    
                                            <div class="mb-4">
                                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                                    Customer Name
                                                </label>
    
                                                <input  readonly :value="gcashInfo.gcash_full_name" class="bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Product Name">
                                            </div>
    
                                            <div class="mb-4">
                                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                                    Payment Status
                                                </label>
    
                                                <input  readonly :value="gcashInfo.payment_status" class="bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Product Name">
                                            </div>
    
                                             <div v-if="gcashInfo.payment_status == 'partial'" class="mb-4">
                                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                                    Remaining Amount to be Paid
                                                </label>
    
                                                <input  readonly :value="'₱ ' + String(totalPrice - gcashInfo.gcash_amount_paid)" class="bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Product Name">
                                            </div>
    
                                            <div class="mb-4">
                                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                                    Amount Paid
                                                </label>
    
                                                <input  readonly :value="'₱ ' + String(gcashInfo.gcash_amount_paid)" class="bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Product Name">
                                            </div>
    
                                            <div class="mb-4">
                                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                                    Reference Number
                                                </label>
    
                                                <input  readonly :value="gcashInfo.gcash_reference_number" class="bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Product Name">
                                            </div>
    
                                    
                                          
                                        </form>
                                    </div>
                                </div>
    
    
    
    
    
                                </div>
    
                        </div>
                    </div>
                </div>
            </div>
        </BreezeAuthenticatedLayout>
    </template>
    