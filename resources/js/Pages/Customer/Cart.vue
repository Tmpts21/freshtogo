<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';

export default { 
    props : ['cart'] ,
    components : { BreezeAuthenticatedLayout , Head } , 
    data () { 
        return { 
        }
    },
    mounted() { 
    },
    methods : {
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Your shopping cart 
            </h2>
        </template>

        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 bg-white border-b border-gray-200">
                         <div class="relative overflow-x-auto sm:rounded-lg font-bold">

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
                                        price 
                                    </th>
                                    
                                </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="product in cart" :key="product.id" class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                    <th scope="row"  class="px-2 py-1 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{product.id}}
                                    </th>
                                    <td class="px-2 py-1" >
                                        {{product.name}}
                                    </td>
                                    <td class="px-2 py-1" >
                                        {{product.categoryName}}
                                    </td>
                                    <td class="px-2 py-1" >
                                        {{product.brand}}
                                    </td>
                                     <td class="px-2 py-1" >
                                        {{product.price}}
                                    </td>
                                     <td class="px-2 py-1" >
                                        <button>+</button>
                                        {{product.price}}
                                        <button>-</button>

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
