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
							<th class="column-1">#ID</th>
							<th class="column-2">Product</th>
							<th class="column-3">Price</th>
						</tr>
						<span v-if="invoices.length == 0" class="m-text21 w-size20 w-full-sm">
							Chưa có đơn hàng nào
						</span>
						<tr v-else v-for="invoice in invoices" :key="invoice.id" class="table-row">
							<td class="column-1">{{invoice.id}}</td>
							<td class="column-2">
                                {{invoice.product}}
                            </td>
							<td class="column-3">{{invoice.created_at}}</td>
						</tr>
						
					</table>
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
                invoices: []
            }
        },
        created () {
            axios.get('http://book.com/invoice').then(response => {
                this.invoices = response.data;
                this.invoices.forEach(invoice => {
                    var tmp = [];
                    invoice.books.forEach(book => {
                        tmp.push(book.name);
                    })
                    invoice.product = tmp.join(' , ');
                })
            }).catch(errors => {
                ErrorHelper.error(errors);
            })
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
        },
        methods: {
            // Methods
		},
    }
</script>
