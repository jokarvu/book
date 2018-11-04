a<template>
    <div class="container-fluid">
        <div class="row gap-20">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <h4 class="c-grey-900 mB-20">Add New Book</h4>
                    <div class="mT-30">
                        <form class="container" @submit.prevent="AddNewBook">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Name </label>
                                    <input v-model="book.name" v-validate data-vv-rules="required" class="form-control" :class="{'is-invalid': errors.has('name') }" name="name" type="text">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('name')">
                                        {{ errors.first('name') }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Price</label>
                                    <input v-model="book.price" v-validate data-vv-rules="required|numeric" class="form-control" :class="{'is-invalid': errors.has('price') }" name="price" type="text">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('price')">
                                        {{ errors.first('price') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Author</label>
                                    <input v-model="book.author" v-validate data-vv-rules="required" class="form-control" :class="{'is-invalid': errors.has('author') }" name="author" type="text">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('author')">
                                        {{ errors.first('author') }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Thumbnail</label>
                                    <input @change="thumbnail" v-validate data-vv-rules="required" class="form-control-file" :class="{'is-invalid': errors.has('thumbnail') }" name="thumbnail" type="file">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('thumbnail')">
                                        {{ errors.first('thumbnail') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Category</label>
                                    <select v-model="book.category_id" v-validate data-vv-rules="required" class="form-control" :class="{'is-invalid': errors.has('category_id') }" name="category_id">
                                        <option value="" disabled>Choose...</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                                    </select>
                                    <div class="form-control-feedback text-danger" v-show="errors.has('category_id')">
                                        {{ errors.first('category_id') }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Quantity </label>
                                    <input v-model="book.quantity" v-validate data-vv-rules="required|numeric" class="form-control" :class="{'is-invalid': errors.has('quantity') }" name="quantity" type="numeric">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('quantity')">
                                        {{ errors.first('quantity') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Description (Optional) </label>
                                    <input v-model="book.description" v-validate data-vv-rules="" class="form-control" :class="{'is-invalid': errors.has('description') }" name="description" type="text">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('description')">
                                        {{ errors.first('description') }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row-reverse clearfix">
                                <router-link to="/admin/user" class="btn btn-danger mL-5">Cancel</router-link>
                                <button class="btn btn-primary" type="submit">Add New Book</button>
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
        mounted () {
            var app = this;
            axios.get('/book/create').then(function (json) {
                app.categories = json.data;
            }).catch(function (errors) {
                // console.log(json);
                toastr.error(errors.message);
            });
        },
        methods: {
            AddNewBook () {
                // Tao lan dau tien neu dien du form khong hoat dong? Need fix
                var app = this;
                var form = new FormData();
                for (var key in app.book) {
                    form.append(key, app.book[key]);
                }
                app.$validator.validateAll().then(result => {
                    if (!result) {
                        // validation failed
                        toastr.error('Có lỗi xảy ra');
                    } else {
                        axios.post('/book', form).then(function (json) {
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
