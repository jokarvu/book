<template>
    <div class="container-fluid">
        <div class="row gap-20">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <h4 class="c-grey-900 mB-20">Thêm Nhà Cung Cấp</h4>
                    <div class="mT-30">
                        <form class="container" @submit.prevent="AddNewSupplier">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Tên</label>
                                    <input v-model="supplier.name" v-validate data-vv-rules="required" class="form-control" :class="{'is-invalid': errors.has('name') }" name="name" type="text">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('name')">
                                        {{ errors.first('name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row-reverse clearfix">
                                <!-- <div class="col-md-9"></div> -->
                                <!-- <div class="col-md-3 col-md-offset-9 float-right"> -->
                                    <router-link to="/admin/supplier" class="btn btn-danger">Hủy</router-link>
                                    <button class="btn btn-primary mR-5" type="submit">Thêm nhà cung cấp</button>
                                <!-- </div> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import 'tinymce';
    export default {
        data () {
            return {
                supplier: {
                    name: ''
                }
            }
        },
        mounted () {
            //
        },
        methods: {
            AddNewSupplier () {
                var app = this;
                app.$validator.validateAll().then(result => {
                    if (!result) {
                        toasr.error('Please check your post. A required field is empty!');
                    } else {
                        axios.post('http://book.com/supplier', app.supplier).then(json => {
                            toastr.success(json.data.message);
                            app.$router.go(-1);
                        }).catch(errors => {
                            console.log(errors);
                            ErrorHelper.error(errors);
                        })
                    }
                })
            }
        }
    }
</script>
