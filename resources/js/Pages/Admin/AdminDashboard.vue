<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import  DoughnutChart  from '../Charts/Dougnut.vue';
import BarChart from '../Charts/Bar.vue';
import LineChart from '../Charts/Line.vue' ;
export default { 
    props : ['statusTotal'],
    components : { 
        BreezeAuthenticatedLayout ,
        Head ,
        DoughnutChart ,
        BarChart , 
        LineChart
    },
    data() {
        return { 
             doughnutChartData: {
                labels: ['Pending', 'Cancelled', 'Delivered'],
                datasets: [
                {
                    backgroundColor: ['#0ea5e9', '#ef4444', '#65a30d'],
                    data: [this.statusTotal[2].total, this.statusTotal[0].total , this.statusTotal[1].total]
                }
                ]
            },
        }
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📈 Sales Dashboard 
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="h-5 border-b-2 font-bold border-lime-500 mt-5 mb-5 text-2xl text-center">
                            <span class="bg-white px-5">Sales for the Month</span>
                        </div>
                        <DoughnutChart class="mb-5" :chartData="this.doughnutChartData"></DoughnutChart>

                        <div class="flex gap-12 justify-center">
                            <div class="max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                                <div class="flex flex-col items-center pb-5">
                                    <div v-if="statusTotal[2].total" class="mt-5 text-lg font-bold">{{statusTotal[2].total}}</div> 
                                    <div v-else  class="mt-5 text-lg font-bold">0</div> 
                                    <h5 class="mb-1 px-5 text-xl font-medium text-gray-900 dark:text-white">Total Pending</h5>
                                    <h5 class="mb-1 px-5 text-xl font-medium text-gray-900 dark:text-white">🕜</h5>
                                    <h5 class="mb-1 px-5 text-xl font-medium text-gray-900 dark:text-white">₱ {{new Number(statusTotal[2].totalPrice).toLocaleString()}}</h5>
                                </div>
                            </div>

                            <div class="max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                                <div class="flex flex-col items-center pb-5">
                                    <div v-if="statusTotal[0].total" class="mt-5 text-lg font-bold">{{statusTotal[0].total}}</div> 
                                    <div v-else class="mt-5 text-lg font-bold">0</div> 
                                    <h5 class="mb-1 px-5 text-xl font-medium text-gray-900 dark:text-white">Total Cancelled</h5>
                                    <h5 class="mb-1 px-5 text-xl font-medium text-gray-900 dark:text-white">❌</h5>
                                    <h5 class="mb-1 px-5 text-xl font-medium text-gray-900 dark:text-white">₱ {{new Number(statusTotal[0].totalPrice).toLocaleString()}}</h5>

                                </div>
                            </div>

                            <div class="max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                                <div class="flex flex-col items-center pb-5">
                                    <div v-if="statusTotal[1].total" class="mt-5 text-lg font-bold">{{statusTotal[1].total}}</div> 
                                    <div v-else class="mt-5 text-lg font-bold">0</div> 
                                    <h5 class="mb-1 px-5 text-xl font-medium text-gray-900 dark:text-white">Total Delivered</h5>
                                    <h5 class="mb-1 px-5 text-xl font-medium text-gray-900 dark:text-white">🚚</h5>
                                    <h5 class="mb-1 px-5 text-xl font-medium text-gray-900 dark:text-white">₱ {{new Number(statusTotal[1].totalPrice).toLocaleString()}}</h5>

                               </div>
                            </div>
                        </div>
                    <br>
                    <hr>
                    <br>

                        <div class="h-5 border-b-2 font-bold border-lime-500 mt-5 mb-5 text-2xl text-center">
                            <span class="bg-white px-5">Monthly Sales</span>
                        </div>

                            <LineChart class="mt-2 px-64 py-2 "></LineChart>

                        <div class="h-5 border-b-2 font-bold border-lime-500 mt-5 mb-5  text-2xl text-center">
                            <span class="bg-white px-5">Kg(sold) per Product</span>
                        </div>

                            <BarChart class="mt-2 px-64 py-2 "></BarChart>



                        
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
