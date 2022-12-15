<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head , Link } from '@inertiajs/inertia-vue3';
import Cart from '@/Pages/Customer/Cart.vue';
import { deliveryFares } from './Fares';
import { Inertia } from '@inertiajs/inertia'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'


export default { 
    props : ['products' , 'categories' , 'errors'] ,
    components : { 
        Carousel,
        Slide,
        Pagination, 
        Navigation,
        BreezeAuthenticatedLayout , Head , Cart ,Link  } , 
    data () { 
        return { 
            cart : [],
            gcashImage : null ,
            gcashRefNo : '', 
            freshToGo : this.products,
            displayGcashPayment : false , 
            displayCart : false ,
            cartProducts : [] ,
            fares : deliveryFares ,
            fareCharge : null ,
            fareSelect : this.$page.props.auth.user.city,
            isCheckout : false ,
            modeOfPayment : 'Cash on Delivery',
            displayError : false ,
            displayExceedError : false , 
            displayAmountError : false , 
            amountExceedError : false , 
            gcashAmountPaid : null , 
            gcashFullName : '',
            searchInput : '', 
            category : 'all',
            address : this.$page.props.auth.user.street_address + ' ' +  this.$page.props.auth.user.barangay + ' ' + this.$page.props.auth.user.city + ' City ' +  this.$page.props.auth.user.postal_code 
        }
    },
    mounted() { 
        this.fillCart(); 
        this.getDeliveryFare();
    },
    methods : {
        fillCart() { 
            for(let i = 0 ; i < this.freshToGo.length; i++ ) { 
                this.freshToGo[i].quantity = 0 ; 
                let product = { 
                    id : this.freshToGo[i].id , 
                    quantity : 0 , 
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
                    if(this.cart[i].quantity == 0 ) { 
                        return 
                    }
                    else { 
                        return this.cart[i].isAdded = true ;
                    }
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
            var quantity ;
            for(let i = 0 ; i < this.cart.length ; i ++ ) { 
                if(this.cart[i].id === p_id) { 
                    this.cart[i].quantity+=1  ;
                    quantity = this.cart[i].quantity
                    this.cart[i].total += this.cart[i].price  ;
                    
                }
            }

            for(let i = 0 ; i < this.freshToGo.length ; i ++ ) { 
                if(this.freshToGo[i].id === p_id) { 
                    this.freshToGo[i].quantity = quantity ;
                }
            }
        },
        decreaseQuantity(p_id) { 
            var quantity ; 
            for(let i = 0 ; i < this.cart.length ; i ++ ) { 
                if(this.cart[i].id === p_id) { 

                    if(this.cart[i].quantity > 1 ) { 
                        this.cart[i].quantity-=1  ;
                        quantity = this.cart[i].quantity;
                        this.cart[i].total -= this.cart[i].price  ;
                    }
                    else {this.cart[i].isAdded = false ; }
                
                }
            }

            for(let i = 0 ; i < this.freshToGo.length ; i ++ ) { 
                if(this.freshToGo[i].id === p_id) { 
                    this.freshToGo[i].quantity = quantity ;
                    return
                }
            }
        },
        deleteProduct(p_id){ 
            this.cartProducts = this.cartProducts.filter(product => { 
                return product.id != p_id ;
            });

            for(let i = 0 ; i < this.cart.length ; i ++ ) { 
                if(this.cart[i].id === p_id) { 
                     this.cart[i].isAdded = false ; 
                     this.cart[i].quantity = 0 ; 
                }
            }

            for(let i = 0 ; i < this.freshToGo.length ; i ++ ) { 
                if(this.freshToGo[i].id === p_id) { 
                    this.freshToGo[i].quantity = 0 ; 
                }
            }

            return 
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
            let AllProductsPrice = 0 ; 

            // check quantity 
            if(this.validateQuantity()) { 
                for (let i = 0 ; i < this.cartProducts.length ; i ++ ) { 
                    AllProductsPrice += this.cartProducts[i].total
                    if (this.cartProducts[i].quantity > this.cartProducts[i].stock) {
                         this.displayError = false ; 
                         this.displayAmountError = false ; 
                         this.amountExceedError = false ; 
                         this.displayExceedError = true ; 
                         return
                        
                    }

                    orders.push(JSON.stringify(this.cartProducts[i]))
                }

           if(this.modeOfPayment == 'Gcash') { 
                if(this.gcashAmountPaid < 0 || this.gcashAmountPaid == 0 || this.gcashAmountPaid < AllProductsPrice / 2 ) { 
                    this.displayError = false ; 
                    this.displayExceedError = false ; 
                    this.displayAmountError = true ; 
                    this.amountExceedError = false ; 
                    return
                }else if(this.gcashAmountPaid > AllProductsPrice ) { 
                    this.displayError = false ; 
                    this.displayAmountError = false ;
                    this.displayExceedError = false ; 
                    this.amountExceedError = true ; 

                    return
                }
           } 

            

            const orderdata = { 
                cart : orders ,
                deliveryCharge : this.fareCharge  ,
                mop : this.modeOfPayment ,
                address : this.address ,
                gcash_proof_of_payment : this.gcashImage ,
                gcash_reference_number : this.gcashRefNo,
                gcash_amount_paid : this.gcashAmountPaid,
                gcash_full_name : this.gcashFullName,
                totalPriceOfAllProductsWithDeliveryFee : AllProductsPrice + parseInt(this.fareCharge) , 
            }
                this.displayError = false  ; 
                return Inertia.post('customer/placeorder', {data:orderdata})
            }

            this.displayError = true ;
            this.displayExceedError = false ;
            this.displayAmountError = false ;
            this.amountExceedError = false ;

     


            return ;




            

        },

        validateQuantity(){ 
            for(let i = 0 ; i < this.cartProducts.length; i++ ) { 
                if(this.cartProducts[i].quantity < 5 ) { 
                    return false ; 
                }
            }

            return true ; 

            },

        onChangeSelect() { 
            if (this.modeOfPayment == "Gcash") { 
                return this.displayGcashPayment = true ;
            }

            return this.displayGcashPayment = false ;

        },


         onChangeInput() { 
            if(this.searchInput === '' ) { 
                this.freshToGo = this.products 
            }
            else { 
                this.freshToGo = this.products 
                this.freshToGo = this.freshToGo.filter((product)=>{
                    return this.searchInput.toLowerCase().split(' ').every(
                        v => product.name.toLowerCase().includes(v) ||  
                        product.brand.toLowerCase().includes(v) 
                )
                })
            }
        },

         onChangeCategorySelect() { 
            if (this.category === 'all') { 
                this.freshToGo = this.products 
            }
            else { 
            
                 this.freshToGo = this.products 
                 this.freshToGo = this.freshToGo.filter((product) => { 
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
     

        <div class="py-12">
            
            <button  v-if="!displayCart" @click="shoppingCart()" class="fixed rounded-full z-90 bottom-10 text-green-500 right-8 float-right bg-gray-100 hover:bg-gray-200 text-white font-bold py-2 px-4 border-2 border-gray-700 ">
                           <span><i class="fa-solid fa-cart-shopping text-lime-500 text-lg "></i> </span>  View Shopping Cart
            </button>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white  sm:rounded-lg">
                       
                    
                    <div class="p-6 bg-white border-b border-gray-200">
                                    
                                
                      

                          <button  v-if="displayCart" @click="shoppingCart()" class="fixed rounded-full z-90 bottom-10 text-green-500 right-8 float-right bg-gray-100 hover:bg-gray-200 text-white font-bold py-2 px-4 border-2 border-gray-700 ">
                           <span><i class="fa-solid fa-cart-shopping text-lime-500 text-lg "></i> </span>  Back to products
                         </button>

                        <Transition name="slide-fade">
                                 <div v-if="$page.props.flash.error" class="alert">
                                <div class="rounded bg-red-100 text-red-700 p-4 font-bold" role="alert">
                                    <p>{{ $page.props.flash.error }} 😔</p>
                                </div>
                                <br>
                            </div>
                        </Transition>

        
            <div v-if="!displayCart  && !isCheckout" class="flex justify-between  mr-5">
                <div class="mb-3 xl:w-96">
                    <select v-model="category" @change="onChangeCategorySelect()" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <option value="all" selected >Choose Categories</option>
                        <option v-for="categoryOption in categories" :key="categoryOption.key" :value="categoryOption.id">{{categoryOption.name}}</option>
                    </select>
                </div>

                <div class="mb-3 xl:w-96">
                    <div class="input-group relative flex flex-wrap items-stretch w-full mb-4">
                        <input @change="onChangeInput" v-model="searchInput" type="search" class="form-control relative flex-auto min-w-0 block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="Search by name or brand " aria-label="Search" aria-describedby="button-addon2">
                    </div>
                </div>
            </div>
            <div  v-if="!this.freshToGo.length" class="rounded bg-orange-200 text-red-800 p-4 font-bold" role="alert">
                        nothing here 😭
             </div>
        <Transition name="slide-fade">

        <div class="content-center"  v-if="!displayCart  && !isCheckout">
            

            <div class="w-full p-4 text-center bg-white border rounded-lg sm:p-8">
                <h5 class="mb-2 text-3xl font-bold text-lime-500 ">Welcome to fresh2go 🎉</h5>
                <p class="mb-5 text-base mb-12 text-gray-700 sm:text-lg font-bold">" In The Meat Time, Steak With Us. We Meat Standard Quality. You Meat The World To Us. Choose The Best, Choose Us "</p>
                <div class=" space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                    <div>
                        <img class="object-cover h-full w-96 rounded-lg " src="/storage/image/ads1.png">
                    </div>

                    <div>
                        <img class="object-cover h-full w-96 rounded-lg " src="/storage/image/ads2.png">
                    </div>

                    <div>
                        <img class="object-cover h-full w-96 rounded-lg " src="/storage/image/ads3.png">
                    </div>
                </div>

            
                
            </div>


            <h5 class="p-4 text-3xl font-bold text-lime-500 ">Our Products 🥩</h5>


             <Carousel :items-to-show="1" :wrap-around="false" class="bg-gray-100">
                                <slide v-for="product in freshToGo" :key="product.id" class="mb-5">
                                    <!-- <img :src="'/storage/' + product.image" width="500" height="300" class="rounded-3xl" alt=""> -->
                                    <div class="mt-8 group relative">
                                        <div class="min-h-80 aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75 lg:aspect-none lg:h-96">
                                       
                                            <Link  :href="route('customer.view_product' , {id : product.id })" >
                                            <img :src="'/storage/' + product.image" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-fit object-center lg:h-full lg:w-full">
                                        </Link>
                                        </div>
                                        <div class="mt-4 flex justify-between">
                                           
                                        <div>
                                            <h3 class="text-sm text-gray-700">
                                            <Link  :href="route('customer.view_product' , {id : product.id })"  class="font-bold text-lg text-lime-600">
                                                <span aria-hidden="true" class="absolute inset-0"></span>
                                                {{product.name}} 
                                            </Link>
                                            </h3>
                                        </div>

                                      
                                        <p class="font-bold  text-lime-600">{{product.sold}}kg(sold) 🙌</p>
                                        </div>

                                        <div class="bg-lime-100 border border-lime-400 text-lime-700 px-4 py-3 rounded relative" role="alert">
                                            <span class="block sm:inline">{{product.description}}</span>
                                        </div>
                                    </div>
                             
                                </Slide>
                            <template #addons class="pt-5">
                                <p class="font-bold text-lg pt-5">✨ </p>
                                <Navigation />
                                <Pagination/>
                            </template>
                            
            </Carousel>

           
        </div>
     
    </transition>
   
            <Transition name="slide-fade">

                        
                

                    <div v-if="!displayCart  && !isCheckout" class="p-6 flex flex-wrap items-center justify-center">
                

                    <div class="font-bold font-medium mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                      
                        

                            <div v-for="product in freshToGo" :key="product.id" class=" border-2 border-lime-600 rounded-md p-4 " >
                               
                               <div class="w-full min-h-80 rounded-md  lg:h-80 lg:aspect-none">
                                <img :src="'/storage/' + product.image "  class="w-full h-full object-center object-fit lg:w-full lg:h-full">
                                </div>

                                <div class="mt-4 flex justify-between">
                                    <h3 class="text-sm text-gray-700">
                                        <Link :href="route('customer.view_product' , {id : product.id })"   class="text-sm text-lime-400"  v-html="product.name" />({{product.brand}})
                                    </h3>
                                <p class="text-sm font-bold text-gray-900">₱ {{product.price}}  <small>(kg)</small> 
                                </p>
                        </div>
                        <div>
                            <span class="mt-1 text-sm text-gray-500">{{categories[product.category_id - 1 ].name}}</span>
                            <span class="float-right mt-1 text-sm text-gray-500">Stock: {{product.stock}}<small>(kg)</small></span>
                            <span class="float-right mt-1 text-sm text-gray-500 mr-3">{{product.sold}}kg<small>(sold)</small></span>
                        </div>

                            <button v-if="!isAddedToCart(product.id)" @click="addToCart(product.id)" class="mt-3 bg-lime-500 hover:bg-lime-700 text-white font-bold py-2 px-4 border border-lime-700 rounded">
                                <span> add to cart 🛒</span>   
                            </button>
                        
                            <button v-else @click="removeToCart(product.id)" class="mt-3 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 border border-gray-700 rounded">
                                added to cart 🛒
                            </button>
                            <div>
                                <button @click="decreaseQuantity(product.id)"> <i class="fa-solid fa-minus text-red-500 text-lg ml-2 "></i></button>
                                {{product.quantity}}
                                <button @click="increaseQuantity(product.id)"> <i class="fa-solid fa-plus text-green-500 text-lg mr-2 "></i></button>

                            </div>
                          
                        </div>

                    </div>

                             
                    </div>

                    </Transition>
                <Transition name="slide-fade">
                    <div v-if="displayCart">
                         <div v-if="cartProducts.length">

                        <div class="bg-lime-100 border-l-4 rounded-lg border-lime-500 text-lime-700 p-4" role="alert">
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
                                        Remaining Stocks 
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
                                         ₱ {{product.stocks}}
                                    </td>
                                     <td class="px-2 py-1" >
                                         ₱ {{product.total}}
                                    </td>
                                     <td class="px-2 py-1" >
                                        <button @click="decreaseQuantity(product.id)"> <i class="fa-solid fa-minus text-red-500 text-lg ml-2 "></i></button>
                                            {{product.quantity}}
                                        <button @click="increaseQuantity(product.id)"> <i class="fa-solid fa-plus text-green-500 text-lg mr-2 "></i></button>


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
                                <input readonly v-model="$page.props.auth.user.barangay" class="w-full px-2 py-2 text-gray-700 bg-gray-100 rounded" id="fare"  type="text" required="" placeholder="delivery fare" aria-label="Email">
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
                            <select v-model="modeOfPayment" @change="onChangeSelect()"  class="inline-block mt-2 w-1/2 pr-1  appearance-none w-full text-gray-700  rounded border border-gray-400 hover:border-gray-500 px-2 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="Cash on Delivery" selected >Cash on Delivery</option>
                                    <option value="Gcash" >Gcash E payment</option>
                            </select>

                           </div>

                            <Transition name="slide-fade">
                                <div v-if="displayGcashPayment" class="mt-8 bg-blue-100 border blue-red-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                                     <div class="mt-4 bg-lime-100 border border-lime-400 text-lime-700 px-4 py-3 rounded relative" role="alert">
                                        <br>
                                        <span class="block sm:inline">Note: <b>As our beloved customer. The minimum amount for Gcash E Payment is half of the total Price. You can pay it full once your order is delivered ! Thank you 🙏  </b> </span>
                                        <br>        
                                        <br>
                                        <strong class="font-bold">Payment Procedure 💳</strong>

                                            <ol class="list-decimal ml-5 ">
                                                <li>Open Gcash App and Log in your account </li>
                                                <li>Click Send</li>
                                                <li>Click Express Send</li>
                                                <li>Enter Mobile Number of FreshToGo <span class="font-bold">(09163410823 - FreshToGo)</span> and the amount to be paid</li>
                                                <li>Click Next and Proceed</li>
                                            </ol>
                                        
                                        <br>
                                        <span class="block sm:inline">Please Screenshot the payment as this will act as your proof of payment. Also please Input the correct values based on the label provided. Full Name and Amount Paid Input should match the Information inside your proof of payment <b>(Failure in following the guidelines provided will result to a delayed delivery)</b> </span>
                                    </div>
                                     <div class="mt-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                            Proof of payment <small>(please insert the image of the payment)</small>
                                        </label>

                                        <input required type="file" @input="gcashImage = $event.target.files[0]" />
                                    </div>

                                    <div class="mt-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                            Full Name 
                                        </label>

                                        <input  v-model="gcashFullName" class="w-full px-2 py-2 text-gray-700 bg-gray-100 rounded" id="street"  type="text" required placeholder="Enter Full Name " aria-label="Email">
                                    </div>

                                    <div class="mt-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                            Amount Paid
                                        </label>

                                        <input  v-model="gcashAmountPaid" class="w-full px-2 py-2 text-gray-700 bg-gray-100 rounded" id="street"  type="number" required placeholder="Enter Amount Paid" aria-label="Email">
                                    </div>
                                    
                                    
                                    <div class="mt-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="category_name">
                                            Reference Number <small>(Reference number can be found on your screenshot of proof of payment )</small> 
                                        </label>

                                        <input  v-model="gcashRefNo" class="w-full px-2 py-2 text-gray-700 bg-gray-100 rounded" id="street"  type="number" required placeholder="Enter reference number of the payment" aria-label="Email">
                                    </div>
                                </div>
                            </Transition>


                           <Transition name="slide-fade">

                           

                             <div v-if="displayError" class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Sorry 😔</strong>
                                <span class="block sm:inline"> minimum of 5kg per product </span>
                            </div>

                             <div v-else-if="displayExceedError" class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Sorry 😔</strong>
                                <span class="block sm:inline"> Quantity(kg) is Exceeding our stocks(kg) </span>
                            </div>

                            <div v-else-if="displayAmountError" class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Sorry 😔</strong>
                                <span class="block sm:inline"> Partial payments should be atleast half of the total amount to be paid You need atleast <span class="font-bold">(₱{{getTotalPrice() / 2 }})</span> to continue this transaction Thank you. </span>
                            </div>

                            <div v-else-if="amountExceedError" class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Sorry 😔</strong>
                                <span class="block sm:inline"> The Gcash Amount Paid input should not exceed total price payment.  </span>
                            </div>
                        </Transition>
                    <br>

                            <button @click="placeOrder()" class="ml-3 float-right font-bold text-white bg-lime-700 hover:bg-lime-800 focus:ring-4 focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-lime-600 dark:hover:bg-lime-700 focus:outline-none dark:focus:ring-lime-800" >Place Order</button>

                        </div>

                    </div>

                </div>



                        </div>
                        <div v-else>
                             <div class="bg-lime-100 text-center border-l-4 rounded-lg border-lime-500 text-lime-700 p-4" role="alert">
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

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    display: none;
}

</style>
