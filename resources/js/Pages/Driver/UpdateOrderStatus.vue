<script >
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'

export default {
  props : ['order'] , 
  components : {  
    BreezeAuthenticatedLayout ,
    Head
  },
  
  data() {
    return { 
        displayRemarks : false ,
        displayProof : false 
    }
  },

  setup (props) {
    const form = reactive({
        orderId : props.order.id , 
        customerId : props.order.user_id, 
        status : props.order.status, 
        orderStatus: '',
        remarks : '',
        image : null 
    })

    function submit() { 
         Inertia.post('/driver/update/order', form)
    }

    return { form , submit , props }
  },
  methods : { 
    onChangeSelect() { 
        if(this.form.orderStatus == 'cancelled') { 
            this.displayRemarks = true ; 
            this.displayProof = false ;
        }else if (this.form.orderStatus == 'delivered') { 
            this.displayProof = true 
            this.displayRemarks = false ; 
        }
        else { 
            this.displayRemarks = false ; 
            this.displayProof = false ;
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
                Update Order status 
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 flex flex-col justify-center items-center">
                           <div v-if="$page.props.flash.success" class="alert">
                                <div class="bg-green-100 text-green-700 p-4" role="alert">
                                    <p>{{ $page.props.flash.success }}</p>
                                </div>
                                <br>
                            </div>

                            <div v-if="$page.props.flash.error" class="alert">
                                <div class="bg-red-100 text-red-700 p-4" role="alert">
                                    <p>{{ $page.props.flash.error }}</p>
                                </div>
                                <br>
                            </div>

                        <div class="w-full max-w-lg">
                        <form @submit.prevent="submit()"  class="bg-white rounded px-8 pt-6 pb-8 mb-4">
                            <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Status
                            </label>

                                 <select @change="onChangeSelect()" required v-model="form.orderStatus" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="delivered">Delivered</option>
                                </select>
                            </div>
                            
                            <div v-if="displayProof">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                        Proof of delivery 
                                    </label>
                                </div>  
                                <input type="file" class="mb-10" @input="form.image = $event.target.files[0]" required />
                            </div>
                            
                            <div v-if="displayRemarks">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                        Remarks
                                    </label>

                                    <textarea v-model="form.remarks" required class="resize-none rounded-md " rows="5" cols="48" placeholder="Enter the reason why the order is cancelled"></textarea>
                                </div>
                            </div>

                            <button :disabled="form.processing" type="submit" class="float-right font-bold text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Save 📁</button>

                        </form>
               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
