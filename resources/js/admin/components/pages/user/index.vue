<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="c-grey-900 mB-20">Thống kê người dùng</h4>
                        </div>
                        <div class="col-md-6">
                            <router-link to="/admin/user/create" class="btn btn-info float-right">Thêm người dùng</router-link>
                        </div>
                    </div>

                    <table id="user-index" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Tên đăng nhập</th>
                                <th scope="col">Email</th>
                                <th scope="col">Quyền</th>
                                <th scope="col">Tình trạng</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Ngày sửa</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users" :key="user.id" :id="'user-'+user.id">
                                <th scope="row" class="text-center">{{user.id}}</th>
                                <td>{{user.username}}</td>
                                <td>{{user.email}}</td>
                                <td>{{user.role.name}}</td>
                                <td class="text-center">
                                    <span class="badge badge-pill c-white" :class="user.deleted_at ? 'bgc-red-700' : 'bgc-green-400'">{{user.deleted_at ? 'Đã xóa' : 'Hoạt động'}}</span>
                                </td>
                                <td class="text-center">{{user.created_at}}</td>
                                <td class="text-center">{{user.updated_at}}</td>
                                <td class="text-center">
                                    <router-link :to="{name: 'UserShow', params: {slug: user.username}}" class="btn btn-sm btn-success">Xem</router-link>
                                    <router-link :to="{name: 'UserUpdate', params: {slug: user.username}}" class="btn btn-sm btn-info">Sửa</router-link>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" :data-target="'#usermodal-'+user.id">
                                        Xóa
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" :id="'usermodal-'+user.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <button type="button" @click="DeleteUser(user.id)" class="btn btn-danger" data-dismiss="modal">Xóa</button>
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
                users: [],
                // table: null
            };
        },
        mounted() {
            var app = this;
            // Get product data
            axios.get("http://book.com/user").then(function(json) {
                app.users = json.data;
                console.log(json.data);
            }).catch(function(json) {
                ErrorHelper.error(errors);
            });
        },
        updated() {
            var app = this;
            app.table = $("#user-index").DataTable({
                stateSave: true,
            });
        },
        methods : {
            DeleteUser (id) {
                var app = this;
                axios.delete('http://book.com/user/' + id).then(response => {
                    toastr.success(response.data.message);
                    app.table.rows('#user-'+id).remove().draw(false);
                }).catch(errors => {
                    ErrorHelper.error(errors);
                });
            }
        }
    };
</script>
