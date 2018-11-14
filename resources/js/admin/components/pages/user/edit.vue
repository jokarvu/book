a<template>
    <div class="container-fluid">
        <div class="row gap-20">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <h4 class="c-grey-900 mB-20">Cập nhật người dùng</h4>
                    <div class="mT-30">
                        <form class="container" @submit.prevent="UpdateUser">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tên đăng nhập </label>
                                    <input v-model="user.username" v-validate data-vv-rules="required" class="form-control" :class="{'is-invalid': errors.has('name') }" name="name" type="text">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('name')">
                                        {{ errors.first('name') }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Email </label>
                                    <input v-model="user.email" v-validate data-vv-rules="required|email" class="form-control" :class="{'is-invalid': errors.has('email') }" name="email" type="text">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('email')">
                                        {{ errors.first('email') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Quyền</label>
                                    <select v-model="user.role_id" v-validate data-vv-rules="required" class="form-control" :class="{'is-invalid': errors.has('role') }" name="role">
                                        <option value="" disabled>Choose...</option>
                                        <option v-for="role in roles" :key="role.id" :value="role.id">{{role.name}}</option>
                                    </select>
                                    <div class="form-control-feedback text-danger" v-show="errors.has('role')">
                                        {{ errors.first('role') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Địa chỉ (Tùy chọn) </label>
                                    <input v-model="user.address" v-validate data-vv-rules="" class="form-control" :class="{'is-invalid': errors.has('address') }" name="address" type="text">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('address')">
                                        {{ errors.first('address') }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row-reverse clearfix">
                                <button @click.prevent="$router.go(-1)" class="btn btn-danger mL-5">Hủy</button>
                                <button class="btn btn-primary" type="submit">Cập Nhật</button>
                            </div>
                        </form>
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
                roles: [],
            }
        },
        mounted () {
            var app = this;
            var slug = app.$route.params.slug;
            axios.get('http://book.com/user/' + slug + '/edit').then(function (json) {
                app.roles = json.data.roles;
                app.user = json.data.user;
            }).catch(function (errors) {
                ErrorHelper.error(errors);
            });
        },
        methods: {
            UpdateUser () {
                // Tao lan dau tien neu dien du form khong hoat dong? Need fix
                var app = this;
                var slug = app.$route.params.slug;
                app.$validator.validateAll().then(result => {
                    if (!result) {
                        // validation failed
                        toastr.error('Validation failed. Invalid input!');
                    } else {
                        axios.put('http://book.com/user/' + slug , app.user).then(function (json) {
                            toastr.success(json.data.message);
                            // console.log("OK");
                            app.$router.push({path: '/admin/user'});
                        }).catch(errors => {
                            // console.log(errors);
                            ErrorHelper.error(errors);
                        });
                    }
                }).catch(function (errors) {
                    ErrorHelper.error(errors)
                });
            }
        }
    }
</script>
