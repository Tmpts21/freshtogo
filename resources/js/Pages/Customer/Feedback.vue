<script >
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'

export default {
  props : ['product' , 'orderId'] , 
  components : {  
    BreezeAuthenticatedLayout ,
    Head
  },
 
  setup (props) {
    const form = reactive({
      orderId : props.orderId , 
      product_id: props.product.id, 
      feedback : '' ,
      stars : null , 
    })


    function submit() { 
         Inertia.post('/customer/save/feedback', form)
    }

    return { form , submit}
  },
}
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add feedback  
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
                        <div class="w-full max-w-sm">
                        <form @submit.prevent="submit()"  class="bg-white rounded px-8 pt-6 pb-8 mb-4">

                            <div class="mb-4 ">
                              <label for="status" class="font-bold block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Rate our product 🙏</label>
                            <select v-model="form.stars" id="status" class="font-bold bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="5">5 stars</option>
                                <option value="4">4 stars</option>
                                <option value="3">3 stars</option>
                                <option value="2">2 stars</option>
                                <option value="1">1 stars</option>
                            </select>

                            </div>

                             <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                        Add you feedback here 🙈
                                    </label>

                                    <textarea v-model="form.feedback" required class="resize-none rounded-md " rows="5" cols="33" placeholder="Type here your feedback "></textarea>
                                </div>

                            <button :disabled="form.processing" type="submit" class="float-right text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 font-bold">Save 📁</button>

                        </form>
               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
