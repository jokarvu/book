a<template>
    <div class="container-fluid">
        <div class="row gap-20">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <h4 class="c-grey-900 mB-20">Cập nhật thông tin sách</h4>
                    <div class="mT-30">
                        <form class="container" @submit.prevent="UpdateBook">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tên </label>
                                    <input v-model="book.name" v-validate data-vv-rules="required" class="form-control" :class="{'is-invalid': errors.has('name') }" name="name" type="text">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('name')">
                                        {{ errors.first('name') }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Giá</label>
                                    <input v-model="book.price" v-validate data-vv-rules="required|numeric" class="form-control" :class="{'is-invalid': errors.has('price') }" name="price" type="text">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('price')">
                                        {{ errors.first('price') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tác giả</label>
                                    <input v-model="book.author" v-validate data-vv-rules="required" class="form-control" :class="{'is-invalid': errors.has('author') }" name="author" type="text">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('author')">
                                        {{ errors.first('author') }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Hình ảnh</label>
                                    <input @change="thumbnail" v-validate data-vv-rules="" class="form-control-file" :class="{'is-invalid': errors.has('thumbnail') }" name="thumbnail" type="file">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('thumbnail')">
                                        {{ errors.first('thumbnail') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Danh mục</label>
                                    <select v-model="book.category_id" v-validate data-vv-rules="required" class="form-control" :class="{'is-invalid': errors.has('category_id') }" name="category_id">
                                        <option value="" disabled>Choose...</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                                    </select>
                                    <div class="form-control-feedback text-danger" v-show="errors.has('category_id')">
                                        {{ errors.first('category_id') }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Số lượng </label>
                                    <input v-model="book.quantity" v-validate data-vv-rules="required|numeric" class="form-control" :class="{'is-invalid': errors.has('quantity') }" name="quantity" type="numeric">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('quantity')">
                                        {{ errors.first('quantity') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Mô tả (Tùy chọn) </label>
                                    <input v-model="book.description" v-validate data-vv-rules="" class="form-control" :class="{'is-invalid': errors.has('description') }" name="description" type="text">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('description')">
                                        {{ errors.first('description') }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row-reverse clearfix">
                                <router-link to="/admin/book" class="btn btn-danger mL-5">Hủy</router-link>
                                <button class="btn btn-primary" type="submit">Cập nhật</button>
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
                book: {
                    name: '',
                    author: '',
                    description: '',
                    category_id: '',
                    quantity: 0,
                    price: 0,
                    thumbnail: null,
                },
                categories: [],
            }
        },
        created () {
            var app = this;
            var slug = app.$route.params.slug;
            axios.get('/book/' + slug + '/edit').then(function (json) {
                app.categories = json.data.categories;
                app.book  = json.data.book;
            }).catch(function (errors) {
                // console.log(json);
                toastr.error(errors.message);
            });
        },
        mounted () {
            //
        },
        methods: {
            UpdateBook () {
                // Laravel bug. How to fix: change method to post. append a _method key to formData
                var app = this;
                var slug = app.$route.params.slug;
                var form = new FormData();
                for (var key in app.book) {
                    form.append(key, app.book[key]);
                }
                form.append('_method', 'PUT');
                app.$validator.validateAll().then(result => {
                    if (!result) {
                        // validation failed
                        toastr.error('Có lỗi xảy ra');
                    } else {
                        console.log(form.getAll('name'));
                        axios.post('/book/' + slug, form).then(function (json) {
                            toastr.success(json.data.message);
                            app.$router.push({path: '/admin/book'});
                        }).catch(errors => {
                            ErrorHelper.error(errors);
                        });
                    }
                }).catch(function () {
                    toastr.error('Có lôi xảy ra!');
                });
            },
            thumbnail (e) {
                var app = this;
                var file = e.target.files || e.dataTansfer.files;
                app.book.thumbnail = file[0];
            }
        }
    }
</script>
