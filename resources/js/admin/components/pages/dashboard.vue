<template>
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item  w-100">
            <div class="row gap-20">
                <!-- #Toatl Visits ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Total Users</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <span id="sparkline1" class="sparkline"></span>
                                </div>
                                <div class="peer">
                                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">{{ total_users }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- #Total Page Views ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Total Posts</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <span id="sparkline2" class="sparkline"></span>
                                </div>
                                <div class="peer">
                                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-red-50 c-red-500">{{ total_posts }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- #Unique Visitors ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Pending Posts</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <span id="sparkline3" class="sparkline"></span>
                                </div>
                                <div class="peer">
                                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-purple-50 c-purple-500">{{ total_pending_posts }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- #Bounce Rate ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Today Posts</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <span id="sparkline4" class="sparkline"></span>
                                </div>
                                <div class="peer">
                                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500">{{ today_posts }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gap-20">
                <div class="col-md-3">
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Today Users</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <span id="sparkline5" class="sparkline"></span>
                                </div>
                                <div class="peer">
                                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">{{ today_users }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layers bd bgc-white p-20 mT-10">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Total Views</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <span id="sparkline6" class="sparkline"></span>
                                </div>
                                <div class="peer">
                                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">{{ total_views }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layers bd bgc-white p-20 mT-10">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Categories</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <span id="sparkline7" class="sparkline"></span>
                                </div>
                                <div class="peer">
                                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">{{ total_categories }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layers bd bgc-white p-20 mT-10">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Tags</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <span id="sparkline8" class="sparkline"></span>
                                </div>
                                <div class="peer">
                                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">{{ total_tags }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-10">Popular Posts</h4>
                        <h6 class="mB-20">Five posts with highest view will be shown</h6>
                        <table id="popular-posts" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">#ID</th>
                                    <th scope="col">Heading</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Body</th>
                                    <th scope="col">Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="post in popular_posts" :key="post.id" :id="'post-'+post.id">
                                    <th scope="row" class="text-center">{{post.id}}</th>
                                    <td>{{post.heading}}</td>
                                    <td>{{post.category.name}}</td>
                                    <td>{{post.body}}</td>
                                    <td class="text-center">{{post.views}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import * as $ from 'jquery';
    import 'jquery-sparkline';
    // import 'datatables';
    export default {
        data () {
            return {
                total_users: 0,
                today_users: 0,
                total_posts: 0,
                today_posts: 0,
                total_pending_posts: 0,
                total_categories: 0,
                total_views: 0,
                total_tags: 0,
                popular_posts: null
            }
        },
        mounted () {
            var app = this;
            // Mini chart dashboard counter
            var value = [0, 5, 6, 10, 9, 12, 4, 9];
            $('#sparkline1').sparkline(value, {type: 'bar', barColor: 'red'});
            $('#sparkline2').sparkline(value, {type: 'bar', barColor: 'green'});
            $('#sparkline3').sparkline(value, {type: 'bar', barColor: 'blue'});
            $('#sparkline4').sparkline(value, {type: 'bar', barColor: 'orange'});
            $('#sparkline5').sparkline(value, {type: 'bar', barColor: 'violet'});
            $('#sparkline6').sparkline(value, {type: 'bar', barColor: 'cyan'});
            $('#sparkline7').sparkline(value, {type: 'bar', barColor: 'purple'});
            $('#sparkline8').sparkline(value, {type: 'bar', barColor: 'yellow'});

            // Counter
            // axios.get('/api/admin/dashboard').then(json => {
            //     app.total_users = json.data.total_users;
            //     app.today_users = json.data.today_users;
            //     app.total_posts = json.data.total_posts;
            //     app.today_posts = json.data.today_posts;
            //     app.total_pending_posts = json.data.total_pending_posts;
            //     app.total_categories = json.data.total_categories;
            //     app.total_views = json.data.total_views;
            //     app.total_tags = json.data.total_tags;
            //     app.popular_posts = json.data.popular_posts;
            // }).catch(json => {
            //     toastr.error('Could not load data!');
            // });
        },
        // updated () {
        //     var app = this;
        //     app.table = $('#popular-posts').DataTable({
        //         'retrieve': true,
        //         'searching': false,
        //         "order": [[ 4, "desc" ]],
        //         'paging': false
        //     });
        // }
    }
</script>
