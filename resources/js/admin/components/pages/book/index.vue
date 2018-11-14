<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="c-grey-900 mB-20">Thống kê sách</h4>
                        </div>
                        <div class="col-md-6">
                            <router-link to="/admin/book/create" class="btn btn-info float-right">Thêm đầu sách</router-link>
                        </div>
                    </div>

                    <table id="book-index" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Tác giả</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Tình trạng</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="book in books" :key="book.id" :id="'book-'+book.id">
                                <th scope="row" class="text-center">{{book.id}}</th>
                                <td>{{book.name}}</td>
                                <td>{{book.author}}</td>
                                <td>{{book.category.name}}</td>
                                <td>{{book.price}}</td>
                                <td class="text-center">{{book.quantity}}</td>
                                <td class="text-center">
                                    <span class="badge badge-pill c-white" :class="book.deleted_at ? 'bgc-red-700' : (book.quantity_left == 0 ? 'bgc-orange-700' : 'bgc-green-400')">{{book.deleted_at ? 'Đã xóa' : (book.quantity_left == 0 ? 'Hết hàng' : 'Còn hàng')}}</span>
                                </td>
                                <td class="text-center">
                                    <router-link :to="{name: 'BookShow', params: {slug: book.slug}}" class="btn btn-sm btn-success">Xem</router-link>
                                    <router-link :to="{name: 'BookUpdate', params: {slug: book.slug}}" class="btn btn-sm btn-info">Sửa</router-link>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" :data-target="'#bookmodal-'+book.id">
                                        Xóa
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" :id="'bookmodal-'+book.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Xóa sách</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Tất cả hóa đơn về sách cũng sẽ được chuyển vào thùng rác. Bạn có muốn tiếp tục không?
                                                </div>
                                                    <div class="modal-footer">
                                                    <button type="button" @click="DeleteBook(book.id)" class="btn btn-danger" data-dismiss="modal">Xóa</button>
                                                    <button type="button" class="btn btn-info" data-dismiss="modal">Hủy</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    export default {
        data() {
            return {
                books: [],
                // table: null
            };
        },
        mounted() {
            var app = this;
            // Get product data
            axios.get("/book").then(function(json) {
                app.books = json.data;
            }).catch(function(json) {
                ErrorHelper.error(errors);
            });
        },
        updated() {
            var app = this;
            app.table = $("#book-index").DataTable({
                stateSave: true,
            });
        },
        methods : {
            DeleteBook (id) {
                var app = this;
                axios.delete('/book/' + id).then(response => {
                    toastr.success(response.data.message);
                    app.table.rows('#book-'+id).remove().draw(false);
                }).catch(errors => {
                    ErrorHelper.error(errors);
                });
            }
        }
    };
</script>
