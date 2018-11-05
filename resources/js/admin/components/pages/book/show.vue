a<template>
    <div class="container-fluid">
        <div class="row gap-20">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <h4 class="c-grey-900 mB-20">Thông tin sách</h4>
                    <div class="row">
                        <div class="col-md-4 text-center mT-30">
                            <img :src="'/storage/product/' + book.slug + '.jpg'" :alt="book.name" width="300px">
                        </div>
                        <div class="col-md-8 mT-30">
                            <h4>Tên sách: {{book.name}}</h4>
                            <h4>Tác giả: {{book.author}}</h4>
                            <h4>Thể loại: {{book.category.name}}</h4>
                            <h4>Số lượng: {{book.quantity}}</h4>
                            <h4>Giá bán: {{book.price}}</h4>
                            <h4>Tổng đơn hàng: {{book.invoices_count}}</h4>
                            <h4>Mô tả: {{book.description}}</h4>
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse clearfix">
                        <router-link to="/admin/book" class="btn btn-danger mL-5">Back</router-link>
                        <router-link :to="'/admin/book/' + book.slug + '/edit'" class="btn btn-primary">Update Book</router-link>
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
                    category: {},
                    description: '',
                    quantity: '',
                    slug: '',
                    price: ''
                },
            }
        },
        mounted () {
            var app = this;
            var slug = app.$route.params.slug;
            axios.get('/book/' + slug).then(function (json) {
                app.book = json.data;
            }).catch(function (errors) {
                ErrorHelper.error(errors);
                app.$router.go(-1);
            });
        },
    }
</script>
