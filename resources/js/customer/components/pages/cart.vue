<template>
    <div>
        <!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-image: url(images/heading-pages-01.jpg);">
		<h2 class="l-text2 t-center">
			Cart
		</h2>
	</section>

	<!-- Cart -->
	<section class="cart bgwhite p-t-70 p-b-100">
		<div class="container">
			<!-- Cart item -->
			<div class="container-table-cart pos-relative">
				<div class="wrap-table-shopping-cart bgwhite">
					<table class="table-shopping-cart">
						<tr class="table-head">
							<th class="column-1"></th>
							<th class="column-2">Product</th>
							<th class="column-3">Price</th>
							<th class="column-4 p-l-70">Quantity</th>
							<th class="column-5">Total</th>
						</tr>
						<span v-if="carts.length == 0" class="m-text21 w-size20 w-full-sm">
							Chưa có sản phẩm nào
						</span>
						<tr v-else v-for="(book,key) in carts" :key="book.id" class="table-row">
							<td class="column-1">
								<div @click="removeBookFromCart(book)" class="cart-img-product b-rad-4 o-f-hidden">
									<img :src="'/storage/product/' + book.slug + '.jpg'" alt="IMG-PRODUCT">
								</div>
							</td>
							<td class="column-2">{{book.name}}</td>
							<td class="column-3">{{book.price}}</td>
							<td class="column-4">
								<div class="flex-w bo5 of-hidden w-size17">
									<button @click="changeQuantity(-1, key, book.price, book.quantity_left)" class="btn-num-product-down color1 flex-c-m size7 bg8 eff2">
										<i class="fs-12 fa fa-minus" aria-hidden="true"></i>
									</button>

									<input v-model="book.quantity" class="size8 m-text18 t-center num-product" type="number" name="num-product1">

									<button @click="changeQuantity(1, key, book.price, book.quantity_left)" class="btn-num-product-up color1 flex-c-m size7 bg8 eff2">
										<i class="fs-12 fa fa-plus" aria-hidden="true"></i>
									</button>
								</div>
							</td>
							<td class="column-5">{{book.price * book.quantity}}</td>
						</tr>
						
					</table>
				</div>
			</div>

			<div class="flex-w flex-sb-m p-t-25 p-b-25 bo8 p-l-35 p-r-60 p-lr-15-sm">
				<div class="flex-w flex-m w-full-sm">
					<div class="size11 bo4 m-r-10">
						<input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="coupon-code" placeholder="Coupon Code">
					</div>

					<div class="size12 trans-0-4 m-t-10 m-b-10 m-r-10">
						<!-- Button -->
						<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
							Apply coupon
						</button>
					</div>
				</div>

				<div class="size10 trans-0-4 m-t-10 m-b-10">
					<!-- Button -->
					<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
						Update Cart
					</button>
				</div>
			</div>

			<!-- Total -->
			<div class="bo9 w-size18 p-l-40 p-r-40 p-t-30 p-b-38 m-t-30 m-r-0 m-l-auto p-lr-15-sm">
				<h5 class="m-text20 p-b-24">
					Cart Totals
				</h5>

				<!--  -->
				<div class="flex-w flex-sb-m p-b-12">
					<span class="s-text18 w-size19 w-full-sm">
						Subtotal:
					</span>

					<span class="m-text21 w-size20 w-full-sm">
						{{subtotal}}
					</span>
				</div>

				<!--  -->
				<div class="flex-w flex-sb bo10 p-t-15 p-b-20">
					<span class="s-text18 w-size19 w-full-sm">
						Shipping:
					</span>
					<span class="m-text21 w-size20 w-full-sm">
						10% giá trị đơn hàng
					</span>
				</div>

				<!--  -->
				<div class="flex-w flex-sb-m p-t-26 p-b-30">
					<span class="m-text22 w-size19 w-full-sm">
						Total:
					</span>

					<span class="m-text21 w-size20 w-full-sm">
						{{total}}
					</span>
				</div>

				<div class="size15 trans-0-4">
					<!-- Button -->
					<button @click="checkout()" class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
						Proceed to Checkout
					</button>
				</div>
			</div>
		</div>
	</section>
    </div>
</template>
<script>
	import { EventBus } from '../../../event'
    import 'select2';
    export default {
        data () {
            return {
                carts: [],
				subtotal: 0,
				total: 0
            }
        },
        created () {
            if (localStorage.carts) {
                // Tai cart tu localStorage
                this.carts = JSON.parse(localStorage.getItem('carts'));
                this.carts.forEach(book => {
                    this.subtotal += book.price * book.quantity;
				});
				this.total = this.subtotal + this.subtotal*0.1;
            }
        },
        mounted () {
            $(".selection-1").select2({
                minimumResultsForSearch: 20,
                dropdownParent: $('#dropDownSelect1')
            });

            $(".selection-2").select2({
                minimumResultsForSearch: 20,
                dropdownParent: $('#dropDownSelect2')
			});
			EventBus.$on('removeBookFromCartHeader', (carts) => {
				this.carts = carts;
			})
        },
        methods: {
            changeQuantity (value, key, price, left) {
				console.log(this.carts[key].quantity + value);
                if (this.carts[key].quantity + value > left) {
                    toastr.warning('Trong kho chỉ còn ' + left + ' đầu sách này');
                    this.carts[key].quantity = left;
                    return;
                }
                this.carts[key].quantity += value;
				this.subtotal += value * price;
				this.total = this.subtotal + this.subtotal*0.1;
				localStorage.setItem('carts', JSON.stringify(this.carts));
				EventBus.$emit('changeQuantity', this.carts);
                console.log(localStorage.getItem('carts'));
			},
			checkout () {
				axios.get('http://book.com/auth/check').then(response => {
					axios.post('http://book.com/invoice', this.carts).then(response2 => {
						toastr.success(response2.data.message);
						this.$router.push({path: '/'});
						EventBus.$emit('checkedOut');
					}).catch(errors2 => {
						ErrorHelper.error(errors2);
					})
				}).catch(errors => {
					ErrorHelper.error(errors);
				})
			},
			removeBookFromCart (book) {
				this.carts = this.carts.filter(item => {
					return item.id != book.id;
				});
				localStorage.setItem('carts', JSON.stringify(this.carts));
				EventBus.$emit('removeBookFromCart', this.carts);
			}
		},
		watch: {
			carts: function (data) {
				localStorage.setItem('carts', JSON.stringify(data));
				this.subtotal = 0;
				data.forEach(book => {
					this.subtotal += book.price * book.quantity;
				});
				this.total = this.subtotal + this.subtotal * 0.1;
			}
		}
    }
</script>
