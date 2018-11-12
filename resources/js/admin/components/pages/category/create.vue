<template>
    <div class="container-fluid">
        <div class="row gap-20">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <h4 class="c-grey-900 mB-20">Thêm Danh Mục</h4>
                    <div class="mT-30">
                        <form class="container" @submit.prevent="AddNewCategory">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Tên</label>
                                    <input v-model="category.name" v-validate data-vv-rules="required" class="form-control" :class="{'is-invalid': errors.has('name') }" name="name" type="text">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('name')">
                                        {{ errors.first('name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Danh mục cha</label>
                                    <select v-model="category.category_id" v-validate data-vv-rules="" class="form-control" :class="{'is-invalid': errors.has('category_id') }" name="category_id">
                                        <option value="">None</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                                    </select>
                                    <div class="form-control-feedback text-danger" v-show="errors.has('category_id')">
                                        {{ errors.first('category_id') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Mô tả</label>
                                    <input v-model="category.description" v-validate data-vv-rules="required" class="form-control" :class="{'is-invalid': errors.has('description') }" name="description" type="text">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('description')">
                                        {{ errors.first('description') }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row-reverse clearfix">
                                <!-- <div class="col-md-9"></div> -->
                                <!-- <div class="col-md-3 col-md-offset-9 float-right"> -->
                                    <router-link to="/admin/category" class="btn btn-danger">Cancel</router-link>
                                    <button class="btn btn-primary mR-5" type="submit">Add New Post</button>
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
                categories: [],
                category: {
                    name: null,
                    category_id: '',
                    description: '',
                }
            }
        },
        mounted () {
            var app = this;
            axios.get('/category/create').then(function (json) {
                app.categories = json.data;
            }).catch(function (errors) {
                console.log(json);
                ErrorHelper.error(errors);
            });
        },
        methods: {
            AddNewCategory () {
                var app = this;
                app.$validator.validateAll().then(result => {
                    if (!result) {
                        toasr.error('Please check your post. A required field is empty!');
                    } else {
                        axios.post('/category', app.category).then(json => {
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
