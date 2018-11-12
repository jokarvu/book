a<template>
    <div class="container-fluid">
        <div class="row gap-20">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <div class="c-grey-900 mB-20">
                        <h4>Thông tin nhập hàng #{{importer.id}}</h4>
                        <h6>Ngày tạo: {{importer.created_at}}</h6>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-4">
                            <h6>Nhà cung cấp: {{importer.supplier.name}}</h6>
                            <h6>Ghi chú: {{importer.note}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gap-20">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <h4 class="c-grey-900 mB-20">Thông tin sách</h4>
                    <table id="import-show-index" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Tên sách</th>
                                <th scope="col">Giá nhập (VNĐ)</th>
                                <th scope="col">Số lượng (quyển)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="book in importer.books" :key="book.book_id" :id="'book-'+book.book_id">
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
                                <h5>Tổng nhập:</h5>
                            </div>
                            <div class="col-md-2 text-right">
                                <h5>{{total_quantity}} quyển</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 text-right">
                                <h5>Tổng tiền:</h5>
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
                importer: {
                    id: '',
                    note: '',
                    books: [],
                    supplier: {
                        id: '',
                        name: ''
                    }
                },
                total_quantity: 0,
                total: 0,
            }
        },
        mounted () {
            var app = this;
            var id = app.$route.params.id;
            axios.get('/import/' + id).then(function (json) {
                app.importer = json.data;
                app.importer.books.forEach(book => {
                    app.total_quantity += book.quantity;
                    app.total += book.price * book.quantity;
                });
            }).catch(function (errors) {
                ErrorHelper.error(errors);
                app.$router.go(-1);
            });
        },
    }
</script>
