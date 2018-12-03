<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="c-grey-900 mB-20">Thống kê Nhà cung câp</h4>
                        </div>
                        <div class="col-md-6">
                            <router-link to="/admin/supplier/create" class="btn btn-info float-right">Thêm nhà cung cấp</router-link>
                        </div>
                    </div>

                    <table id="supplier-index" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="supplier in suppliers" :key="supplier.id" :id="'supplier-'+supplier.id">
                                <th scope="row" class="text-center">{{supplier.id}}</th>
                                <td>{{supplier.name}}</td>
                                <td>{{supplier.created_at}}</td>
                                <td class="text-center">
                                    <router-link :to="{name: 'SupplierShow', params: {slug: supplier.slug}}" class="btn btn-sm btn-success">Xem</router-link>
                                    <router-link :to="{name: 'SupplierUpdate', params: {slug: supplier.slug}}" class="btn btn-sm btn-info">Sửa</router-link>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" :data-target="'#suppliermodal-'+supplier.id">
                                        Xóa
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" :id="'suppliermodal-'+supplier.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <button type="button" @click="DeleteSupplier(supplier.id)" class="btn btn-danger" data-dismiss="modal">Xóa</button>
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
                suppliers: [],
                // table: null
            };
        },
        mounted() {
            var app = this;
            // Get product data
            axios.get("http://book.com/supplier").then(function(json) {
                app.suppliers = json.data;
            }).catch(function(json) {
                ErrorHelper.error(errors);
            });
        },
        updated() {
            var app = this;
            app.table = $("#supplier-index").DataTable({
                stateSave: true,
            });
        },
        methods : {
            DeleteSupplier (id) {
                var app = this;
                axios.delete('http://book.com/supplier/' + id).then(response => {
                    toastr.success(response.data.message);
                    app.table.rows('#supplier-'+id).remove().draw(false);
                }).catch(errors => {
                    ErrorHelper.error(errors);
                });
            }
        }
    };
</script>
