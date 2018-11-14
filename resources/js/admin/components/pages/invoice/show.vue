a<template>
    <div class="container-fluid">
        <div class="row gap-20">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <div class="c-grey-900 mB-20">
                        <h4>Thông tin đơn hàng #{{invoice.id}}</h4>
                        <h6>Ngày tạo: {{invoice.created_at}}</h6>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-4">
                            <h6>Người mua: {{invoice.user.username}}</h6>
                            <h6>Địa chỉ: {{invoice.address}}</h6>
                            <h6>Ghi chú: {{invoice.note}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gap-20">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <h4 class="c-grey-900 mB-20">Thông tin sách</h4>
                    <table id="invoice-show-index" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Giá (VNĐ)</th>
                                <th scope="col">Số lượng</th>
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
                    <div class="text-right c-grey-900 mb-5">
                        <div class="row">
                            <div class="col-md-10 text-right">
                                <h5>Tổng tạm tính:</h5>
                            </div>
                            <div class="col-md-2 text-right">
                                <h5>{{subtotal}} VNĐ</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 text-right">
                                <h5>Phí vận chuyển:</h5>
                            </div>
                            <div class="col-md-2 text-right">
                                <h5>{{shipping}} VNĐ</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 text-right">
                                <h5>Tổng thanh toán:</h5>
                            </div>
                            <div class="col-md-2 text-right">
                                <h5>{{total}} VNĐ</h5>
                            </div>
                        </div>
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
            axios.get('http://book.com/invoice/' + id).then(function (json) {
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
