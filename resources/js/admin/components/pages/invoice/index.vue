<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="c-grey-900 mB-20">Thống kê đơn hàng</h4>
                        </div>
                        <div class="col-md-6">
                            <router-link to="/admin/invoice/create" class="btn btn-info float-right">Thêm đơn hàng</router-link>
                        </div>
                    </div>

                    <table id="invoice-index" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Người mua</th>
                                <th scope="col">Tình trạng</th>
                                <th scope="col">Phí ship</th>
                                <th scope="col">Ghi chú</th>
                                <th scope="col">Địa chỉ</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Ngày sửa</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="invoice in invoices" :key="invoice.id" :id="'invoice-'+invoice.id">
                                <th scope="row" class="text-center">{{invoice.id}}</th>
                                <td>{{invoice.user.username}}</td>
                                <td class="text-center">
                                    <span class="badge badge-pill c-white" :class="invoice.deleted_at ? 'bgc-red-700' : 'bgc-green-400'">{{invoice.deleted_at ? 'Deleted' : 'Active'}}</span>
                                </td>
                                <td>{{invoice.shipping_tax}}</td>
                                <td>{{invoice.note}}</td>
                                <td class="text-center">{{invoice.address}}</td>
                                <td class="text-center">{{invoice.created_at}}</td>
                                <td class="text-center">{{invoice.updated_at}}</td>
                                <td class="text-center">
                                    <button type="button" class="btn" :class="invoice.status_id == 1 ? 'btn-danger' : (invoice.status_id == 2 ? 'btn-warning' : 'btn-success')">{{invoice.status_id == 1 ? 'Đang chờ' : (invoice.status_id == 2 ? 'Xác nhận' : 'Thành công')}}</button>
                                    <button type="button" class="btn dropdown-toggle dropdown-toggle-split" :class="invoice.status_id == 1 ? 'btn-danger' : (invoice.status_id == 2 ? 'btn-warning' : 'btn-success')" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" @click.prevent="UpdateStatus(invoice.id, 1)">Đang chờ</a>
                                        <a class="dropdown-item" @click.prevent="UpdateStatus(invoice.id, 2)">Xác nhận</a>
                                        <a class="dropdown-item" @click.prevent="UpdateStatus(invoice.id, 3)">Thành công</a>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <router-link :to="{name: 'InvoiceShow', params: {id: invoice.id}}" class="btn btn-sm btn-success">Xem</router-link>
                                    <router-link :to="{name: 'InvoiceUpdate', params: {id: invoice.id}}" class="btn btn-sm btn-info">Sửa</router-link>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" :data-target="'#invoicemodal-'+invoice.id">
                                        Xóa
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" :id="'invoicemodal-'+invoice.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Xóa người dùng</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Tất cả hóa đơn của người dùng sẽ bị chuyển vào thùng rác. Bạn có muốn tiếp tục không?
                                                </div>
                                                    <div class="modal-footer">
                                                    <button type="button" @click="DeleteInvoice(invoice.id)" class="btn btn-danger" data-dismiss="modal">Xóa</button>
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
                invoices: [],
                // table: null
            };
        },
        mounted() {
            var app = this;
            // Get product data
            axios.get("http://book.com/invoice").then(function(json) {
                app.invoices = json.data;
            }).catch(function(json) {
                ErrorHelper.error(errors);
            });
        },
        updated() {
            var app = this;
            app.table = $("#invoice-index").DataTable({
                stateSave: true,
            });
        },
        methods : {
            DeleteInvoice (id) {
                var app = this;
                axios.delete('http://book.com/invoice/' + id).then(response => {
                    toastr.success(response.data.message);
                    app.table.rows('#invoice-'+id).remove().draw(false);
                }).catch(errors => {
                    ErrorHelper.error(errors);
                });
            },
            UpdateStatus(id, status_id) {
                axios.put('http://book.com/invoice/' + id + '/status', {status_id: status_id}).then(response => {
                    toastr.success(response.data.message);
                    this.$router.push({path: '/admin/render'})
                }).catch(errors => {
                    ErrorHelper.error(errors);
                })
            }
        }
    };
</script>
<style>
    .dropdown-item {
        cursor: pointer;
    }
</style>
