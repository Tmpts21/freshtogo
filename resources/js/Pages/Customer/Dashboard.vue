<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia'


export default { 
    props : ['products' , 'categories'] ,
    components : { BreezeAuthenticatedLayout , Head } , 
    data () { 
        return { 
            cart : [],
            freshToGo : this.products,
        }
    },
    mounted() { 
        this.fillCart(); 
    },
    computed() { 
        this.fillCart(); 
    },
    methods : {
        fillCart() { 
            for(let i = 0 ; i < this.freshToGo.length; i++ ) { 
                let product = { 
                    id : this.freshToGo[i].id , 
                    quantity : 0 , 
                    isAdded : false , 
                    categoryName : this.categories[this.freshToGo[i].category_id - 1 ].name , 
                    name : this.freshToGo[i].name , 
                    price  : this.freshToGo[i].price ,
                    stock : this.freshToGo[i].stock , 
                }
                this.cart.push(product); 
            }
        },
        addToCart(cart_id){ 
            this.cart[cart_id - 1 ].isAdded = true ;
                        this.displayCart(); 

        },
        isAddedToCart(cart_id) { 
            for(let i = 0 ; i < this.cart.length ; i ++ ) { 
                if (this.cart[i].id === cart_id) { 
                    if (this.cart[i].isAdded) { 
                        return true ;
                    }
                     break 
                }
            }
            return false ;

        },
        removeToCart(cart_id) { 
            const index = this.cart.findIndex(c => { 
                return c.id == cart_id 
            }); 
     
            if (index > -1) {
                this.cart[cart_id - 1 ].isAdded = false ;
            }
                        this.displayCart(); 

        },
        shoppingCart() { 
            shoppingCart = [] ; 
            let shoppingCart = this.cart.filter(c => { 
                return c.isAdded == true ;
            });
            
            return Inertia.get('customer/cart', {cart:shoppingCart})

        },
        displayCart(){ 
            for(let i = 0 ; i < this.cart.length ; i ++ ) {
                if(this.cart[i].isAdded == true ) console.log(this.cart[i].name); 
            }      
        }
    }

}
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Our products
            </h2>
        </template>

        <div class="py-12">
            
               <button @click="shoppingCart()" class="mt-3 fixed z-90 bottom-10 right-8 float-right bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 border border-green-700 rounded">
                                Shopping cart 
                            </button>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 bg-white border-b border-gray-200">

                        <div class="p-6 flex flex-wrap items-center justify-center">

                      <div class="font-bold font-medium mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                            <div v-for="product in freshToGo" :key="product.id" class=" border-2 border-orange-600 rounded-md p-4 " >
                                <div class="w-full min-h-80  aspect-w-1 aspect-h-1 rounded-md overflow-hidden  lg:h-80 lg:aspect-none">
                                <img :src="'/storage/' + product.image "  class="w-full h-full object-center object-cover lg:w-full lg:h-full">
                                </div>
                                <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-sm text-gray-700">
                                    <p>
                                        <span aria-hidden="true" class="absolute inset-0"></span>
                                        {{product.name}}
                                    </p>
                                    </h3>
                               </div>
                                <p class="text-sm font-bold text-gray-900">₱ {{product.price}}  <small>(kg)</small> </p>
                        </div>
                        <div>
                            <span class="mt-1 text-sm text-gray-500">{{categories[product.category_id - 1 ].name}}</span>
                            <span class="float-right mt-1 text-sm text-gray-500">Stock {{product.stock}}<small>(kg)</small></span>

                        </div>

                            
                            <button v-if="!isAddedToCart(product.id)" @click="addToCart(product.id)" class="mt-3 bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 border border-orange-700 rounded">
                                <span> add to cart </span>   
                            </button>
                            <button v-else @click="removeToCart(product.id)" class="mt-3 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 border border-gray-700 rounded">
                                added to cart
                            </button>
                        </div>

                    </div>
                             
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
