<script>
export default { 
    props : ['cartProducts'] ,
    data() { 
        return { 
            cart : this.cartProducts 
        }
    },
    methods : {
        increaseQuantity(p_id) { 
            for(let i = 0 ; i < this.cart.length ; i ++ ) { 
                if(this.cart[i].id === p_id) { 
                    this.cart[i].quantity+=1  ;
                    this.cart[i].totalPrice += this.cart[i].price  ;
                }
            }
        },
        decreaseQuantity(p_id) { 
            for(let i = 0 ; i < this.cart.length ; i ++ ) { 
                if(this.cart[i].id === p_id) { 
                    if(this.cart[i].quantity > 1 ) { 
                        this.cart[i].quantity-=1  ;
                        this.cart[i].totalPrice -= this.cart[i].price  ;
                    }
                }
            }
        },
        deleteProduct(p_id){ 
            this.cart = this.cart.filter(product => { 
                return product.id != p_id ;
            });
        }
    }
}
</script>

<template>
        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 bg-white border-b border-gray-200">
                       

                    </div>
                </div>
            </div>
        </div>
</template>
