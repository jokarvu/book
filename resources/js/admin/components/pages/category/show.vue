<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="c-grey-900 mB-20">Danh mục của {{category.name}}</h4>
                        </div>
                        <div class="col-md-6">
                            <router-link to="/admin/category/create" class="btn btn-info float-right">Thêm Danh Mục</router-link>
                        </div>
                    </div>

                    <table :id="'table-' + $route.params.slug" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Mã</th>
                                <th scope="col">Số đầu sách</th>
                                <!-- <th scope="col">Category</th> -->
                                <th scope="col">Tình trạng</th>
                                <th scope="col">Cập nhật cuối</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="category in children" :key="category.id" :id="'category-'+category.id">
                                <th scope="row" class="text-center">{{category.id}}</th>
                                <td>{{category.name}}</td>
                                <td>{{category.slug}}</td>
                                <td class="text-center">{{category.books_count}}</td>
                                <td class="text-center">
                                    <span class="badge badge-pill c-white" :class="category.deleted_at ? 'bgc-red-700' : 'bgc-green-400'">{{category.deleted_at ? 'Deleted' : 'Available'}}</span>
                                </td>
                                <td class="text-center">{{category.updated_at}}</td>
                                <td class="text-center">
                                    <router-link :to="{name: 'CategoryShow', params: {slug: category.slug}}" class="btn btn-sm btn-success">Xem</router-link>
                                    <router-link :to="{name: 'CategoryUpdate', params: {slug: category.slug}}" class="btn btn-sm btn-info">Sửa</router-link>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" :data-target="'#category-modal-'+category.id">
                                        Xóa
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" :id="'category-modal-'+category.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    All posts and comments belong to this category will also be deleted. Do you still want to delete this user from your database?
                                                </div>
                                                    <div class="modal-footer">
                                                    <button type="button" @click="DeleteCategory(category.id)" class="btn btn-danger" data-dismiss="modal">Delete</button>
                                                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- </router-link> -->
                        </tbody>
                    </table>
                </div>

                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="c-grey-900 mB-20">Sách của {{category.name}}</h4>
                        </div>
                        <div class="col-md-6">
                            <router-link to="/admin/book/create" class="btn btn-info float-right">Thêm Đầu Sách</router-link>
                        </div>
                    </div>
                    <table :id="'table-category-'+$route.params.slug" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Name</th>
                                <!-- <th scope="col">Category</th> -->
                                <th scope="col">Author</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Available</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created</th>
                                <th scope="col">Updated</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="book in books" :key="book.id" :id="'book-'+book.id">
                                <th scope="row" class="text-center">{{book.id}}</th>
                                <td>{{book.name}}</td>
                                <td>{{book.author}}</td>
                                <td class="text-center">{{book.quantity}}</td>
                                <td class="text-center">{{book.quantity_left}}</td>
                                <td class="text-center">
                                    <span class="badge badge-pill c-white" :class="book.deleted_at || book.quantity_left == 0 ? 'bgc-red-700' : 'bgc-green-400'">{{book.deleted_at || book.quantity_left == 0 ? 'Unavailable' : 'Available'}}</span>
                                </td>
                                <td class="text-center">{{book.created_at}}</td>
                                <td class="text-center">{{book.updated_at}}</td>
                                <td class="text-center">
                                    <div class="col-md-12 tex-center">
                                        <router-link :to="{name: 'BookUpdate', params: {slug: book.slug}}" class="btn btn-sm btn-info">Edit</router-link>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" :data-target="'#bookmodal-'+book.id">
                                            Delete
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" :id="'bookmodal-'+book.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete Book</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        All comments belong to this user will also be deleted. Do you still want to delete this post from your database?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" @click="DeleteBook(book.id)" class="btn btn-danger" data-dismiss="modal">Delete</button>
                                                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                                    </div>
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
    // import * as $ from 'jquery';
    // import 'datatables';
    export default {
        data () {
            return {
                category: {},
                children: [],
                books: [],
            }
        },
        mounted () {
            var self = this;
            var slug = self.$route.params.slug;
            // Get product data
            axios.get('/category/' + slug).then(json => {
                self.books = json.data.books;
                self.category = json.data.category;
                self.children = json.data.children;
            }).catch(errors => {
                self.$router.push({path: '/404'})
            });
        },
        updated () {
            var app = this;
            var slug = app.$route.params.slug;
            app.table = $('#table-'+slug).DataTable({})
            app.table2 = $('#table-category-'+slug).DataTable({})
        },
        watch: {
            '$route' (to, from) {
                var self = this;
                $.fn.dataTable.ext.errMode = 'none';
                // console.log('OK');
                self.$router.push({path: '/render'});
            }
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
            },
            DeleteCategory (id) {
                var app = this;
                axios.delete('/category/' + id).then(response => {
                    toastr.success(response.data.message);
                    app.table.rows('#category-'+id).remove().draw(false);
                }).catch(errors => {
                    ErrorHelper.error(errors);
                });
            }
        }
    }
</script>
