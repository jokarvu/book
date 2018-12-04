<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="c-grey-900 mB-20">Thống kê Quyền</h4>
                        </div>
                        <div class="col-md-6">
                            <router-link to="/admin/role/create" class="btn btn-info float-right">Thêm quyền</router-link>
                        </div>
                    </div>

                    <table id="role-index" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="role in roles" :key="role.id" :id="'role-'+role.id">
                                <th scope="row" class="text-center">{{role.id}}</th>
                                <td>{{role.name}}</td>
                                <td>{{role.created_at}}</td>
                                <td class="text-center">
                                    <router-link :to="{name: 'RoleShow', params: {slug: role.slug}}" class="btn btn-sm btn-success">Xem</router-link>
                                    <router-link :to="{name: 'RoleUpdate', params: {slug: role.slug}}" class="btn btn-sm btn-info">Sửa</router-link>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" :data-target="'#rolemodal-'+role.id">
                                        Xóa
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" :id="'rolemodal-'+role.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <button type="button" @click="DeleteRole(role.id)" class="btn btn-danger" data-dismiss="modal">Xóa</button>
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
                roles: [],
                // table: null
            };
        },
        mounted() {
            var app = this;
            // Get product data
            axios.get("http://book.com/role").then(function(json) {
                app.roles = json.data;
            }).catch(function(json) {
                ErrorHelper.error(errors);
            });
        },
        updated() {
            var app = this;
            app.table = $("#role-index").DataTable({
                stateSave: true,
            });
        },
        methods : {
            DeleteRole (id) {
                var app = this;
                axios.delete('http://book.com/role/' + id).then(response => {
                    toastr.success(response.data.message);
                    app.table.rows('#role-'+id).remove().draw(false);
                }).catch(errors => {
                    ErrorHelper.error(errors);
                });
            }
        }
    };
</script>
