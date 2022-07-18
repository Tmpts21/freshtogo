<script >
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'

export default {
   props: {
    errors: Object,
    categories : [] ,
    product : Object 
  },
  components : {  
    BreezeAuthenticatedLayout ,
    Head
  },
  setup (props) {
    const form = reactive({
      name: props.product.name,
      category_id : props.product.category_id , 
      brand : props.product.brand , 
      stock : props.product.stock , 
      price : props.product.price ,
      image : null ,
      productId : props.product.id
    })


    function submit() { 
         Inertia.post('/admin/update/product', form)
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
                Edit Product
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
                                

                                <img v-if="product.image" :src="'/storage/' + product.image" height="200" width="200" alt=""  class="ml-32 border border-2 mb-4">

                                <div v-if="errors.price" class="text-red-700 " role="alert">
                                    <li>{{errors.image }}</li>
                                </div>

                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                    Edit/Update Image
                                </label>

                                <input type="file" @input="form.image = $event.target.files[0]" />
                                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                            </div>
                            <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Product Name
                            </label>

                            <div v-if="errors.name" class="text-red-700 " role="alert">
                                    <li>{{errors.name }}</li>
                            </div>

                            <input  required v-model="form.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Product Name">
                            </div>

                                <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Category 
                            </label>

                            <div v-if="errors.category" class="text-red-700 " role="alert">
                                    <li>{{errors.category }}</li>
                            </div>

                                <select required v-model="form.category_id" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option :value="null">Choose Category</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>

                           </select>

                            </div>

                                <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Brand
                            </label>

                            <div v-if="errors.brand" class="text-red-700 " role="alert">
                                    <li>{{errors.brand }}</li>
                            </div>

                            <input required v-model="form.brand" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Brand Name">
                            </div>

                                <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Stock(kg)
                            </label>

                            <div v-if="errors.stock" class="text-red-700 " role="alert">
                                    <li>{{errors.stock }}</li>
                            </div>

                            <input required v-model="form.stock" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Enter How many stock">
                            </div>

                            <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                Price(kg)
                            </label>

                            <div v-if="errors.price" class="text-red-700 " role="alert">
                                    <li>{{errors.price }}</li>
                            </div>

                            <input required v-model="form.price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" placeholder="Enter product price">
                            </div>

                   

                            <button :disabled="form.processing" type="submit" class="float-right text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">save</button>

                        </form>
               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
