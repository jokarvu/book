a<template>
    <div class="container-fluid">
        <div class="row gap-20">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <div class="c-grey-900 mB-20">
                        <h4>Thông tin đơn hàng</h4>
                        <h6>Ngày tạo: {{invoice.created_at}}</h6>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <p>{{invoice.user.username}}</p>
                            <p>{{invoice.address}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gap-20">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <h4 class="c-grey-900 mB-20">Thông tin sách</h4>
                    <table id="book-index" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="book in invoice.books" :key="book.book_id" :id="'book-'+book.book_id">
                                <th scope="row" class="text-center">{{book.book_id}}</th>
                                <td>{{book.name}}</td>
                                <td>{{book.price}}</td>
                                <td class="text-center">{{book.quantity}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-right">
                        <p>Subtotal: {{subtotal}}đ<p>
                        <p>Shipping Tax: {{shipping}}</p>
                        <p>Total: {{total}}đ</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                invoice: {
                    id: '',
                    user_id: '',
                    status_id: '',
                    shipping_tax: '',
                    note: '',
                    books: [],
                    user: {
                        id: '',
                        username: ''
                    }
                },
                subtotal: 0,
                total: 0,
                shipping: 0
            }
        },
        mounted () {
            var app = this;
            var id = app.$route.params.id;
            axios.get('/invoice/' + id).then(function (json) {
                app.invoice = json.data;
                app.invoice.books.forEach(element => {
                    app.subtotal += element.price *  element.quantity;
                });
                app.shipping = app.subtotal*app.invoice.shipping_tax/100;
                app.total = app.subtotal + app.shipping;
                console.log(app.total);
            }).catch(function (errors) {
                ErrorHelper.error(errors);
                app.$router.go(-1);
            });
        },
        // updated () {
        //     var app = this;
        //     app.table = $("#book-index").DataTable({
        //         stateSave: true,
        //     });
        // }
    }
</script>
