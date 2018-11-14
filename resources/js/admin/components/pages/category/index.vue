<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="c-grey-900 mB-20">Thống kê danh mục</h4>
                        </div>
                        <div class="col-md-6">
                            <router-link to="/admin/category/create" class="btn btn-info float-right">Thêm Danh Mục</router-link>
                        </div>
                    </div>

                    <table id="category-index" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Mã</th>
                                <th scope="col">Số sách</th>
                                <th scope="col">Danh mục cha</th>
                                <th scope="col">Tình trạng</th>
                                <th scope="col">Cập nhật cuối</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="category in categories" :key="category.id" :id="'category-'+category.id">
                                <th scope="row" class="text-center">{{category.id}}</th>
                                <td>{{category.name}}</td>
                                <td>{{category.slug}}</td>
                                <td class="text-center">{{category.books_count}}</td>
                                <td>{{category.category ? category.category.name : 'None'}}</td>
                                <td class="text-center">
                                    <span class="badge badge-pill c-white" :class="category.deleted_at ? 'bgc-red-700' : 'bgc-green-400'">{{category.deleted_at ? 'Xóa' : 'Hoạt động'}}</span>
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import * as $ from 'jquery';
    // import 'datatables';
    export default {
        data () {
            return {
                categories: [],
            }
        },
        mounted () {
            var app = this;
            // Get product data
            axios.get('http://book.com/category').then(function (json) {
                app.categories = json.data;
            }).catch(function (errors) {
                ErrorHelper.error(errors);
            });
        },
        updated () {
            var app = this;
            app.table = $('#category-index').DataTable({
                stateSave: true,
            });
        },
        methods : {
            DeleteCategory (id) {
                var app = this;
                axios.delete('http://book.com/category/' + id).then(json => {
                    toastr.success(json.data.message);
                    app.table.rows('#category-'+id).remove().draw(false);
                }).catch(errors => {
                    ErrorHelper.error(errors);
                });
            }
        }
    }
</script>
