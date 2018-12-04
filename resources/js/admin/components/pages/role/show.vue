<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="c-grey-900 mB-20">Chi tiết quyền: {{role.name}}</h4>
                        </div>
                        <div class="col-md-6">
                            <router-link to="/admin/user/create" class="btn btn-info float-right">Thêm người dùng</router-link>
                        </div>
                    </div>

                    <table :id="'roleuser-show-' + role.slug" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Cập nhật cuối</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users" :key="user.id" :id="'roleuser-'+user.id">
                                <th scope="row" class="text-center">{{user.id}}</th>
                                <td>{{user.username}}</td>
                                <td class="text-center">{{user.created_at}}</td>
                                <td class="text-center">{{user.updated_at}}</td>
                                <td class="text-center">
                                    <router-link :to="{name: 'UserShow', params: {slug: user.username}}" class="btn btn-sm btn-success">Xem</router-link>
                                    <router-link :to="{name: 'UserUpdate', params: {slug: user.username}}" class="btn btn-sm btn-info">Sửa</router-link>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" :data-target="'#roleuser-modal-'+user.id">
                                        Xóa
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" :id="'roleuser-modal-'+user.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    All posts and comments belong to this category will also be deleted. Do you still want to delete this user from your database?
                                                </div>
                                                    <div class="modal-footer">
                                                    <button type="button" @click="DeleteUser(user.id)" class="btn btn-danger" data-dismiss="modal">Delete</button>
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
                role: {
                    id: '',
                    name: '',
                    slug: ''
                },
                users: []
            }
        },
        mounted () {
            var app = this;
            var slug = app.$route.params.slug;
            // Get product data
            axios.get('http://book.com/role/' + slug).then(function (json) {
                app.role.id = json.data.role.id;
                app.role.name = json.data.role.name;
                app.role.slug = json.data.role.slug;
                app.users = json.data.users;
            }).catch(function (errors) {
                ErrorHelper.error(errors);
            });
        },
        updated () {
            var app = this;
            app.table = $('#roleuser-show-' + app.$route.params.slug).DataTable({
                stateSave: true,
            });
        },
        methods : {
            DeleteUser (id) {
                var app = this;
                axios.delete('http://book.com/user/' + id).then(response => {
                    toastr.success(response.data.message);
                    app.table.rows('#roleuser-'+id).remove().draw(false);
                }).catch(errors => {
                    ErrorHelper.error(errors);
                });
            }
        }
    }
</script>
