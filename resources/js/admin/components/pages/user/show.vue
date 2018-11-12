a<template>
    <div class="container-fluid">
        <div class="row gap-20">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <h4 class="c-grey-900 mB-20">Thông tin người dùng</h4>
                    <div class="mT-30">
                        <h4>Tên đăng nhập: {{user.username}}</h4>
                        <h4>Email: {{user.email}}</h4>
                        <h4>Loại tài khoản: {{user.role.name}}</h4>
                        <h4>Địa chỉ: {{user.address ? user.address : ''}}</h4>
                    </div>
                    <div class="d-flex flex-row-reverse clearfix">
                        <router-link to="/admin/user" class="btn btn-danger mL-5">Quay Lại</router-link>
                        <router-link :to="'/admin/user/' + user.username + '/edit'" class="btn btn-primary">Cập Nhật</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                user: {
                    username: '',
                    email: '',
                    address: '',
                    role_id: ''
                },
            }
        },
        mounted () {
            var app = this;
            var slug = app.$route.params.slug;
            axios.get('/user/' + slug).then(function (json) {
                app.user = json.data;
            }).catch(function (errors) {
                ErrorHelper.error(errors);
            });
        },
    }
</script>
