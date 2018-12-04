<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="c-grey-900 mB-20">Thống kê nhập hàng</h4>
                        </div>
                        <div class="col-md-6">
                            <router-link to="/admin/import/create" class="btn btn-info float-right">Nhập hàng</router-link>
                        </div>
                    </div>

                    <table id="import-index" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Nhà cung cấp</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Ghi chú</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Cập nhật cuối</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in imports" :key="item.id" :id="'import-'+item.id">
                                <th scope="row" class="text-center">{{item.id}}</th>
                                <td>{{item.supplier.name}}</td>
                                <td class="text-center">
                                    <span class="badge badge-pill c-white" :class="item.deleted_at ? 'bgc-red-700' : 'bgc-green-400'">{{item.deleted_at ? 'Đã xóa' : 'Hoạt động'}}</span>
                                </td>
                                <td>{{item.note}}</td>
                                <td class="text-center">{{item.created_at}}</td>
                                <td class="text-center">{{item.updated_at}}</td>
                                <td class="text-center">
                                    <router-link :to="{name: 'ImportShow', params: {id: item.id}}" class="btn btn-sm btn-success">Xem</router-link>
                                    <router-link :to="{name: 'ImportUpdate', params: {id: item.id}}" class="btn btn-sm btn-info">Sửa</router-link>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" :data-target="'#importmodal-'+item.id">
                                        Xóa
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" :id="'importmodal-'+item.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Xóa hóa đơn nhập</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Tất cả hóa đơn của người dùng sẽ bị chuyển vào thùng rác. Bạn có muốn tiếp tục không?
                                                </div>
                                                    <div class="modal-footer">
                                                    <button type="button" @click="DeleteImport(item.id)" class="btn btn-danger" data-dismiss="modal">Xóa</button>
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
import * as $ from "jquery";
// import 'datatables';
    export default {
        data() {
            return {
                imports: [],
                // table: null
            };
        },
        created () {
            axios.get('http://book.com/import').then(response => {
                this.imports = response.data;
            })
        },
        updated() {
            var app = this;
            app.table = $("#import-index").DataTable({
                stateSave: true,
            });
        },
        methods : {
            DeleteImport (id) {
                var app = this;
                axios.delete('http://book.com/import/' + id).then(response => {
                    toastr.success(response.data.message);
                    app.table.rows('#import-'+id).remove().draw(false);
                }).catch(errors => {
                    ErrorHelper.error(errors);
                });
            }
        }
    };
</script>
