<template>
    <div class="container-fluid">
        <div class="row gap-20">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <h4 class="c-grey-900 mB-20">Update Category</h4>
                    <div class="mT-30">
                        <form class="container" @submit.prevent="UpdateCategory">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Name</label>
                                    <input v-model="category.name" v-validate data-vv-rules="required" class="form-control" :class="{'is-invalid': errors.has('name') }" name="name" type="text">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('name')">
                                        {{ errors.first('name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Category</label>
                                    <select v-model="category.category_id" v-validate data-vv-rules="" class="form-control" :class="{'is-invalid': errors.has('category_id') }" name="category_id">
                                        <option value="0">None</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                                    </select>
                                    <div class="form-control-feedback text-danger" v-show="errors.has('category_id')">
                                        {{ errors.first('category_id') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Description</label>
                                    <input v-model="category.description" v-validate data-vv-rules="required" class="form-control" :class="{'is-invalid': errors.has('description') }" name="description" type="text">
                                    <div class="form-control-feedback text-danger" v-show="errors.has('description')">
                                        {{ errors.first('description') }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row-reverse clearfix">
                                <!-- <div class="col-md-9"></div> -->
                                <!-- <div class="col-md-3 col-md-offset-9 float-right"> -->
                                    <button @click.prevent="$router.go(-1)" class="btn btn-danger">Cancel</button>
                                    <button class="btn btn-primary mR-5" type="submit">Update Category</button>
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
                    category_id: 0,
                    description: '',
                }
            }
        },
        mounted () {
            var app = this;
            var slug = app.$route.params.slug;
            axios.get('/category/' + slug + '/edit').then(function (json) {
                app.categories = json.data.categories;
                app.category = json.data.category;
            }).catch(function (errors) {
                ErrorHelper.error(errors);
            });
        },
        methods: {
            UpdateCategory () {
                var app = this;
                var slug = app.$route.params.slug;
                app.$validator.validateAll().then(result => {
                    if (!result) {
                        toasr.error('Please check your post. A required field is empty!');
                    } else {
                        axios.put('/category/' + slug, app.category).then(json => {
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
