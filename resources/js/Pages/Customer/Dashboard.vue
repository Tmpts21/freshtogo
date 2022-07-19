<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import Cart from '@/Pages/Customer/Cart.vue';
import { deliveryFares } from './Fares';
import { Inertia } from '@inertiajs/inertia'

export default { 
    props : ['products' , 'categories'] ,
    components : { 
        BreezeAuthenticatedLayout , Head , Cart } , 
    data () { 
        return { 
            cart : [],
            freshToGo : this.products,
            displayCart : false ,
            cartProducts : [] ,
            fares : deliveryFares ,
            fareCharge : null ,
            fareSelect : this.$page.props.auth.user.city,
            isCheckout : false ,
            modeOfPayment : 'Cash on Delivery',
            displayError : false ,
            address :  this.$page.props.auth.user.postal_code+ ' ' + this.$page.props.auth.user.street_address + ' ' +  this.$page.props.auth.user.barangay + ' ' + this.$page.props.auth.user.city + ' City'
   
        }
    },
    mounted() { 
        this.fillCart(); 
        this.getDeliveryFare();
        console.log(this.fareSelect);
    },
    methods : {
        fillCart() { 
            for(let i = 0 ; i < this.freshToGo.length; i++ ) { 
                let product = { 
                    id : this.freshToGo[i].id , 
                    quantity : 1 , 
                    isAdded : false , 
                    categoryName : this.categories[this.freshToGo[i].category_id - 1 ].name , 
                    name : this.freshToGo[i].name , 
                    price  : parseInt(this.freshToGo[i].price) ,
                    brand  : this.freshToGo[i].brand ,
                    stock : parseInt(this.freshToGo[i].stock) , 
                    image : this.freshToGo[i].image , 
                    total  : parseInt(this.freshToGo[i].price) ,
                }
                this.cart.push(product); 
            }
        },
        addToCart(p_id){ 
            for(let i = 0 ; i < this.cart.length ; i ++ ) { 
                if(this.cart[i].id === p_id) { 
                    return this.cart[i].isAdded = true ;
                }
            }

        },
        isAddedToCart(cart_id) { 
            for(let i = 0 ; i < this.cart.length ; i ++ ) { 
                if (this.cart[i].id === cart_id) { 
                    if (this.cart[i].isAdded) { 
                        return true ;
                    }
                }
            }
            return false ;

        },
        removeToCart(p_id) { 
             for(let i = 0 ; i < this.cart.length ; i ++ ) { 
                if(this.cart[i].id === p_id) { 
                    return this.cart[i].isAdded = false  ;
                }
            }

        },
        shoppingCart() { 
            if(!this.displayCart) { 
                this.cartProducts = this.cart.filter(c => { 
                    return c.isAdded == true ;
                });

                return this.displayCart = true ; 
                 
            }

            return this.displayCart = false ;
            

        },


                increaseQuantity(p_id) { 
            for(let i = 0 ; i < this.cart.length ; i ++ ) { 
                if(this.cart[i].id === p_id) { 
                    this.cart[i].quantity+=1  ;
                    this.cart[i].total += this.cart[i].price  ;
                }
            }
        },
        decreaseQuantity(p_id) { 
            for(let i = 0 ; i < this.cart.length ; i ++ ) { 
                if(this.cart[i].id === p_id) { 
                    if(this.cart[i].quantity > 1 ) { 
                        this.cart[i].quantity-=1  ;
                        this.cart[i].total -= this.cart[i].price  ;
                    }
                }
            }
        },
        deleteProduct(p_id){ 
            this.cartProducts = this.cartProducts.filter(product => { 
                return product.id != p_id ;
            });

            for(let i = 0 ; i < this.cart.length ; i ++ ) { 
                if(this.cart[i].id === p_id) { 
                    return this.cart[i].isAdded = false ; 
                }
            }
        },
        
        getTotalPrice() { 
            let totalPrice = 0 ; 
            this.cartProducts.forEach(products => { 
                totalPrice+= products.total
            });

            return totalPrice + parseInt(this.fareCharge) ; 

            
        },

        getDeliveryFare() { 

            const city = this.fareSelect;
            for (let i = 0 ; i < this.fares.length ; i ++ ) { 
                if (this.fares[i].city === city ) {
                    return this.fareCharge =  this.fares[i].fare; 
                }
            }
        },

        placeOrder() { 
            let orders = [];

            // check quantity 

            if(this.validateQuantity()) { 
                for (let i = 0 ; i < this.cartProducts.length ; i ++ ) { 
                orders.push(JSON.stringify(this.cartProducts[i]))
                }

            const orderdata = { 
                cart : orders ,
                deliveryCharge : this.fareCharge  ,
                mop : this.modeOfPayment ,
                address : this.address
            }
                this.displayError = false  ; 
                return Inertia.post('customer/placeorder', {data:orderdata})
            }

            this.displayError = true ; 

            

        },

        validateQuantity(){ 
            for(let i = 0 ; i < this.cartProducts.length; i++ ) { 
                if(this.cartProducts[i].quantity < 5 ) { 
                    return false ; 
                }
            }

            return true ; 

            }
    }

}
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-orange-500 leading-tight">
                Our Products ✨
            </h2>
        </template>

        <div class="py-12">
            
      
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 bg-white border-b border-gray-200">


                      

                        <button  v-if="!displayCart" @click="shoppingCart()" class="fixed rounded-full z-90 bottom-10 text-green-500 right-8 float-right bg-gray-100 hover:bg-gray-200 text-white font-bold py-2 px-4 border-2 border-gray-700 ">
                           <span><i class="fa-solid fa-cart-shopping text-orange-500 text-lg "></i> </span>  View Shopping Cart
                         </button>

                          <button  v-if="displayCart" @click="shoppingCart()" class="fixed rounded-full z-90 bottom-10 text-green-500 right-8 float-right bg-gray-100 hover:bg-gray-200 text-white font-bold py-2 px-4 border-2 border-gray-700 ">
                           <span><i class="fa-solid fa-cart-shopping text-orange-500 text-lg "></i> </span>  Back to products
                         </button>


            <Transition name="slide-fade">

                    <div v-if="!displayCart  && !isCheckout" class="p-6 flex flex-wrap items-center justify-center">
                        
                    <div class="font-bold font-medium mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                      
                            <div v-for="product in freshToGo" :key="product.id" class=" border-2 border-orange-600 rounded-md p-4 " >
                               
                               <div class="w-full min-h-80 rounded-md  lg:h-80 lg:aspect-none">
                                <img :src="'/storage/' + product.image "  class="w-full h-full object-center object-cover lg:w-full lg:h-full">
                                </div>

                                <div class="mt-4 flex justify-between">
                                    <h3 class="text-sm text-gray-700">
                                        {{product.name}}
                                    </h3>
                                <p class="text-sm font-bold text-gray-900">₱ {{product.price}}  <small>(kg)</small> 
                                </p>
                        </div>
                        <div>
                            <span class="mt-1 text-sm text-gray-500">{{categories[product.category_id - 1 ].name}}</span>
                            <span class="float-right mt-1 text-sm text-gray-500">Stock {{product.stock}}<small>(kg)</small></span>
                        </div>
                            <button v-if="!isAddedToCart(product.id)" @click="addToCart(product.id)" class="mt-3 bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 border border-orange-700 rounded">
                                <span> add to cart 🛒</span>   
                            </button>
                            <button v-else @click="removeToCart(product.id)" class="mt-3 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 border border-gray-700 rounded">
                                added to cart 🛒
                            </button>
                        </div>

                    </div>

                             
                    </div>

                    </Transition>
                <Transition name="slide-fade">
                    <div v-if="displayCart">
                         <div v-if="cartProducts.length">

                        <div class="bg-orange-100 border-l-4 rounded-lg border-orange-500 text-orange-700 p-4" role="alert">
                            <p class="font-bold">Note: </p>
                            <p>Minimum of 5kg per product</p>
                        </div>
                        <br>
                        <div class="relative overflow-x-auto sm:rounded-lg font-bold">

                            <table class="text-center w-full text-sm text-left text-gray-500 dark:text-gray-800 border mx-auto ">
                                <thead class="font-bold text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                         Name 
                                    </th>
                                     <th scope="col" class="px-6 py-3">
                                         Image 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Price 
                                    </th>
                                     <th scope="col" class="px-6 py-3">
                                        quantity 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Delivery Fee 
                                    </th>
                                     <th scope="col" class="px-6 py-3">
                                        action 
                                    </th>
                                    
                                </tr>
                                </thead>

                                <tbody class="mx-auto">
                                    <tr v-for="product in cartProducts" :key="product.id" class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                    <th scope="row"  class="px-2 py-1 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{product.id}}
                                    </th>
                                    <td class="px-2 py-1" >
                                        {{product.name}}
                                    </td>
                                    <td class="px-2 py-1 mx-auto" >
                                        <img :src="'/storage/' + product.image" height="150" width="150" class="" alt="">
                                    </td>
                                     <td class="px-2 py-1" >
                                         ₱ {{product.total}}
                                    </td>
                                     <td class="px-2 py-1" >
                                        <button @click="increaseQuantity(product.id)"> <i class="fa-solid fa-plus text-green-500 text-lg mr-2 "></i></button>
                                        {{product.quantity}}
                                        <button @click="decreaseQuantity(product.id)"> <i class="fa-solid fa-minus text-red-500 text-lg ml-2 "></i></button>

                                    </td>
                                      <td class="px-2 py-1 font-bold text-lg" >
                                         ₱ {{fareCharge}}
                                    </td>
                                    <td class="px-2 py-1" >
                                            <button class="ml-3 font-bold text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800" @click="deleteProduct(product.id)">Delete</button>
                                    </td>

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
                                     <td class="px-2 py-1" >
                                    </td>
                                    <td class="px-2 py-1 font-bold text-lg" >
                                        Total : ₱ {{getTotalPrice()}}
                                    </td>

                                  
                                </tr>
                                </tbody>
                            </table>
                        </div>



                         <div>
                            <div class="leading-loose">
                        <div class="max-w-2xl m-4 p-10 " >
                            <p class="text-gray-800 font-medium text-2xl font-bold">Checkout information</p>
                            <br>
                            <hr>
                            <div class="">
                            <label class="font-bold" for="city">Full Name</label>

                            <input readonly :value="$page.props.auth.user.name"  class="w-full px-2 py-1 text-gray-700 bg-gray-200 rounded" id="cus_name"  type="text" required="" placeholder="Your Name" aria-label="Name">
                            </div>
                          




                            <div class="inline-block mt-2 w-1/2 pr-1">
                           <label class="font-bold" for="city">City</label>
                            <select readonly  v-model="fareSelect" :on-change="getDeliveryFare()" class="block appearance-none w-full text-gray-700 bg-gray-100 rounded border border-gray-400 hover:border-gray-500 px-2 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option v-for="fare in fares" :key="fare.id" :value="fare.city" >{{fare.city}}</option>
                            </select>
                            </div>

                            <div class="inline-block mt-2 w-1/2 pr-1">
                                <label class="font-bold" for="fare">Delivery Fee</label>
                                <input readonly v-model="fareCharge" class="w-full px-2 py-2 text-gray-700 bg-gray-100 rounded" id="fare"  type="text" required="" placeholder="delivery fare" aria-label="Email">
                            </div>

                              <div class="mt-2">
                            <label class="font-bold" for="Barangay">Barangay</label>
                               <input readonly :value="$page.props.auth.user.barangay" class="w-full px-2 py-2 text-gray-700 bg-gray-100 rounded" id="Barangay"  type="text" required="" placeholder="barangay" aria-label="Email">
                           </div>

                               <div class="mt-2">
                            <label class="font-bold" for="street">Street Address</label>
                               <input readonly  :value="$page.props.auth.user.street_address" class="w-full px-2 py-2 text-gray-700 bg-gray-100 rounded" id="street"  type="text" required="" placeholder="barangay" aria-label="Email">
                           </div>

                               <div class="mt-2">
                            <label class="font-bold" for="postal">Postal Code </label>
                               <input readonly :value="$page.props.auth.user.postal_code" class="w-full px-2 py-2 text-gray-700 bg-gray-100 rounded" id="postal"  type="text" required="" placeholder="barangay" aria-label="Email">
                           </div>

                            <div class="mt-4 bg-blue-200 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">🚚 Full address  : </strong>
                                <span class="block sm:inline"> "{{address}}"</span>
                            </div>
                            <br>

                            <div class="mt-2">
                            <label class="font-bold" for="mop">Mode of payment </label>
                            <select v-model="modeOfPayment"  class="inline-block mt-2 w-1/2 pr-1  appearance-none w-full text-gray-700  rounded border border-gray-400 hover:border-gray-500 px-2 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="Cash on Delivery" selected >Cash on Delivery</option>
                                    <option value="Gcash" >Gcash E payment</option>
                            </select>

                           </div>

                           <Transition name="slide-fade">

                             <div v-if="displayError" class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Sorry 😔</strong>
                                <span class="block sm:inline"> minimum of 5kg per product </span>
                            </div>
                        </Transition>
                    <br>

                            <button @click="placeOrder()" class="ml-3 float-right font-bold text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-orange-600 dark:hover:bg-orange-700 focus:outline-none dark:focus:ring-orange-800" >Place Order</button>

                        </div>

                    </div>

                </div>



                        </div>
                        <div v-else>
                             <div class="bg-orange-100 text-center border-l-4 rounded-lg border-orange-500 text-orange-700 p-4" role="alert">
                                <p class="font-bold">Nothing here :( </p>
                            </div>


                        </div>
     


                    </div>

                    </Transition>


                      









                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style>

.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateY(50px);
  opacity: 0;
}

</style>
