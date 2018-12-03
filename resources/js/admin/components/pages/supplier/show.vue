<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="c-grey-900 mB-20">Chi tiết nhà cung cấp: {{supplier.name}}</h4>
                        </div>
                        <div class="col-md-6">
                            <router-link to="/admin/supplier/create" class="btn btn-info float-right">Thêm nhà cung cấp</router-link>
                        </div>
                    </div>

                    <table :id="'supplier-show-' + supplier.slug" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Ghi chú</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Cập nhật cuối</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in supplier.imports" :key="item.id" :id="'import-'+item.id">
                                <th scope="row" class="text-center">{{item.id}}</th>
                                <td>{{item.note}}</td>
                                <td class="text-center">{{item.created_at}}</td>
                                <td class="text-center">{{item.updated_at}}</td>
                                <td class="text-center">
                                    <router-link :to="{name: 'ImportShow', params: {id: item.id}}" class="btn btn-sm btn-success">Xem</router-link>
                                    <router-link :to="{name: 'ImportUpdate', params: {id: item.id}}" class="btn btn-sm btn-info">Sửa</router-link>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" :data-target="'#import-modal-'+item.id">
                                        Xóa
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" :id="'import-modal-'+item.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Import</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    All posts and comments belong to this category will also be deleted. Do you still want to delete this user from your database?
                                                </div>
                                                    <div class="modal-footer">
                                                    <button type="button" @click="DeleteImport(item.id)" class="btn btn-danger" data-dismiss="modal">Delete</button>
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
                supplier: {
                    id: '',
                    name: '',
                    slug: '',
                    created_at: '',
                    updated_at: '',
                    deleted_at: '',
                    imports: []
                },
            }
        },
        mounted () {
            var app = this;
            var slug = app.$route.params.slug;
            // Get product data
            axios.get('http://book.com/supplier/' + slug).then(function (json) {
                app.supplier = json.data;
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
            DeleteImport (id) {
                var app = this;
                axios.delete('http://book.com/import/' + id).then(json => {
                    toastr.success(json.data.message);
                    app.table.rows('#import-'+id).remove().draw(false);
                }).catch(errors => {
                    ErrorHelper.error(errors);
                });
            }
        }
    }
</script>
