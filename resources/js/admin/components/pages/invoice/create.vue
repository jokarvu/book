<template>
    <div class="container-fluid">
        <div class="row gap-20">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <h4 class="c-grey-900 mB-20">Tạo hóa đơn</h4>
                    <div class="mT-30">
                        <form class="container" @submit.prevent="addNewInvoice">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Người mua</label>
                                    <select v-model="user_id" v-validate data-vv-rules="required" class="select_user form-control" :class="{'is-invalid': errors.has('user_id') }" name="user_id">
                                        <option value="" disabled>None</option>
                                        <option v-for="user in users" :key="user.id" :value="user.id">{{user.username}}</option>
                                    </select>
                                    <div class="form-control-feedback text-danger" v-show="errors.has('user_id')">
                                        {{ errors.first('user_id') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Sách</label>
                                    <select data-vv-rules="required" id="select_book" class="form-control" :class="{'is-invalid': errors.has('book') }" name="book">
                                        <option v-for="book in books" :key="book.id" :value="book.id">{{book.name}} | {{book.quantity_left}}</option>
                                    </select>
                                    <div class="form-control-feedback text-danger" v-show="errors.has('book')">
                                        {{ errors.first('book') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div v-for="(book,key) in carts" :key="book.id" class="col-md-6 mb-3">
                                    <div class="row">
                                        <div class="col-md-2 text-center">
                                            <img :src="'/storage/product/' + book.slug + '.jpg'" alt="" width="80" height="134">
                                        </div>
                                        <div class="col-md-8 ml-5">
                                            <span>{{book.name}}</span><br>
                                            <span>Giá: {{book.price}}đ</span><br>
                                            <input @input="changeQuantity($event, key)" type="number" class="form-control mt-3 col-md-4" :value="book.quantity" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row-reverse clearfix">
                                <!-- <div class="col-md-9"></div> -->
                                <!-- <div class="col-md-3 col-md-offset-9 float-right"> -->
                                    <router-link to="/admin/invoice" class="btn btn-danger">Hủy</router-link>
                                    <button class="btn btn-primary mR-5" type="submit">Tạo Hóa Đơn</button>
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
    import 'select2'
    export default {
        data () {
            return {
                books: [],
                users: [],
                user_id: '',
                carts: [],
                list_books_id: [] // Dung de loc nhung sach da duoc them
            }
        },
        created () {
            axios.get('http://book.com/invoice/create').then(response => {
                this.books = response.data.books;
                this.users = response.data.users;
                this.books.forEach(book => {
                    book.quantity = 1;
                });
            }).catch(errors => {
                ErrorHelper.error(errors);
            });
        },
        mounted () {
            var app = this;
            $('#select_book').select2({
                multiple: true,
                closeOnSelect: false,
                matcher: this.matchCustom,
                placeholder: 'Select books..'
            }).on('change', function () {
                app.$emit('selected', $('#select_book').val());
            })
            this.$on('selected', function (value) {
                if (value.length > app.list_books_id.length) {
                    var list = value.filter(element => {
                        return !app.list_books_id.includes(element);
                    });
                    app.list_books_id = value;
                    var tmp = app.books.filter(book => {
                        return list.includes(book.id.toString());
                    })
                    this.carts.push(tmp[0]);
                } else {
                    console.log("Xoa sach");
                    app.carts = app.carts.filter(book => {
                        return value.includes(book.id.toString());
                    })
                    app.list_books_id = value;
                }
            })
        },
        methods: {
            changeQuantity(e, key) {
                this.carts[key].quantity = e.target.value;
            },
            matchCustom(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                return data;
                }

                // Do not display the item if there is no 'text' property
                if (typeof data.text === 'undefined') {
                return null;
                }

                // `params.term` should be the term that is used for searching
                // `data.text` is the text that is displayed for the data object
                if (data.text.indexOf(params.term) > -1) {
                var modifiedData = $.extend({}, data, true);
                modifiedData.text += ' (matched)';

                // You can return modified objects from here
                // This includes matching the `children` how you want in nested data sets
                return modifiedData;
                }

                // Return `null` if the term should not be displayed
                return null;
            },
            addNewInvoice () {
                var app = this;
                axios.post('http://book.com/invoice', {"user_id":app.user_id, "carts": app.carts}).then(response => {
                    toastr.success(response.data.message);
                    app.$router.push({path: '/admin/invoice'});
                }).catch(errors => {
                    ErrorHelper.error(errors);
                });
            }
        },
    }
</script>
<style>
    @import '~select2/dist/css/select2.css';
</style>
