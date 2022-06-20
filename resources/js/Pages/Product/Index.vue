<script >
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head , Link } from '@inertiajs/inertia-vue3';


export default { 
    props : ['products' , 'categories'] ,
    components : { 
        BreezeAuthenticatedLayout ,
        Head ,
        Link    
    },
    
    data() { 
        return { 
            listOfProducts : this.products ,
            category : 'all',
            searchInput : '' ,
        }
    } ,

    computed : { 
                onChangeInput() { 

            if(this.searchInput === '' ) { 
                this.listOfProducts = this.products 
            }
            else { 
                this.listOfProducts = this.products 
                this.listOfProducts = this.listOfProducts.filter((product)=>{
                    return this.searchInput.toLowerCase().split(' ').every(
                        v => product.name.toLowerCase().includes(v) ||  
                        product.brand.toLowerCase().includes(v) 
                )
                })
            }
           
        }
    },

    methods : { 
        onChangeSelect() { 
            if (this.category === 'all') { 
                this.listOfProducts = this.products 
            }
            else { 
                 this.listOfProducts = this.products 
                 this.listOfProducts = this.listOfProducts.filter((product) => { 
                    return product.category_id == this.category
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
                Products Table
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="relative overflow-x-auto sm:rounded-lg font-bold">

                                <Link :href="route('create.product')" class="float-right text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" v-html="'Add new'"/>
                                <div class="inline-block relative w-64">

                                <select v-model="category" @change="onChangeSelect()" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="all" selected >Choose Categories</option>
                                    <option v-for="categoryOption in categories" :key="categoryOption.key" :value="categoryOption.id">{{categoryOption.name}}</option>
                                    
                                </select>
                                </div>

                                <div class="inline-block relative float-right mr-5">
                                    <div class="mb-3 xl:w-96">
                                        <div class="input-group relative flex flex-wrap items-stretch w-full mb-4">
                                            <input @change="onChangeInput" v-model="searchInput" type="search" class="form-control relative flex-auto min-w-0 block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="Search by name or brand" aria-label="Search" aria-describedby="button-addon2">
                                        </div>
                                    </div>
                                </div>

                            <table class="text-center w-full text-sm text-left text-gray-500 dark:text-gray-800 border ">
                                <thead class="font-bold text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                         Name 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Category Name 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        brand 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        quantity 
                                    </th>

                                    <th scope="col" class="px-6 py-3">
                                        price 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action 
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(product , index) in listOfProducts" :key="index" class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                    <th scope="row" :class="{'bg-gray-200' : index % 2 == 0 }"  class="px-2 py-1 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{product.id}} 
                                    </th>
                                    <td class="px-2 py-1" :class="{'bg-gray-200' : index % 2 == 0 }">
                                        {{product.name}}
                                    </td>
                                    <td class="px-2 py-1" :class="{'bg-gray-200' : index % 2 == 0 }">
                                        {{categories[product.category_id - 1 ].name}}
                                    </td>
                                    <td class="px-2 py-1" :class="{'bg-gray-200' : index % 2 == 0 }">
                                        {{product.brand}}
                                    </td>
                                    <td class="px-2 py-1" :class="{'bg-gray-200' : index % 2 == 0 }">
                                        {{product.quantity}}
                                    </td>
                                    <td class="px-2 py-1" :class="{'bg-gray-200' : index % 2 == 0 }">
                                        {{product.price}}
                                    </td>

                                    <td class="px-2 py-3" :class="{'bg-gray-200' : index % 2 == 0 }">
                                        <Link :href="route('edit.product' , {id : product.id })" class="font-bold text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800"  v-html="'Edit'" />
                                        <Link :href="route('show.product' , {id : product.id })" class="ml-3 font-bold text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"  v-html="'View'" />

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
