<script >
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head , Link } from '@inertiajs/inertia-vue3';

export default { 
    props : ['categories'] ,
    components : { 
        BreezeAuthenticatedLayout ,
        Head,
        Link
    },
}
</script> 

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Categories Table
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

                            <div v-if="$page.props.flash.error" class="alert">
                                <div class="bg-red-100 text-red-700 p-4" role="alert">
                                    <p>{{ $page.props.flash.error }}</p>
                                </div>
                                <br>
                            </div>

                            
                        <div class="relative overflow-x-auto sm:rounded-lg font-bold">

                            <Link :href="route('create.category')" class="float-right text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" v-html="'Add new'"/>
                            <table class="text-center w-full text-sm text-left text-gray-500 dark:text-gray-800 border ">
                                <thead class="font-bold text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Category Name 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Product Count 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action 
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(category , index) in categories" :key="index" class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                    <th scope="row" :class="{'bg-gray-200' : index % 2 == 0 }"  class="px-2 py-1 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{category.id}} 
                                    </th>
                                    <td class="px-2 py-1" :class="{'bg-gray-200' : index % 2 == 0 }">
                                        {{category.name}}
                                    </td>
                                    <td class="px-2 py-1" :class="{'bg-gray-200' : index % 2 == 0 }">
                                        {{category.count}}
                                    </td>
                                    <td class="px-5 py-4" :class="{'bg-gray-200' : index % 2 == 0 }">
                                        <Link :href="route('edit.category' , {id : category.id })" class="font-bold text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800"  v-html="'Edit'" />
                                        <!-- <button type="button" class="font-bold text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">Edit </button> -->
                                        <!-- <Link method="post" :href="route('delete.category' , {id : category.id })" class="ml-3 font-bold text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800"  v-html="'Delete'" /> -->

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
