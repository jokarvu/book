<template>
  <div class="peers ai-s fxw-nw h-100vh">
      <div class="d-n@sm- peer peer-greed h-100 pos-r bgr-n bgpX-c bgpY-c bgsz-cv" style='background-image: url("/images/bg.jpg")'>
        <div class="pos-a centerXY">
          <div class="bgc-white bdrs-50p pos-r" style='width: 120px; height: 120px;'>
            <img class="pos-a centerXY" src="/images/logo.png" alt="">
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 peer pX-40 pY-80 h-100 bgc-white scrollable pos-r" style='min-width: 320px;'>
        <h4 class="fw-300 c-grey-900 mB-40">Register</h4>
        <form @submit.prevent="register">
          <div class="form-group">
            <label class="text-normal text-dark">Email</label>
            <input type="email" class="form-control" placeholder="admin@example.com" v-model="user.email">
          </div>
          <div class="form-group">
            <label class="text-normal text-dark">Username</label>
            <input type="text" class="form-control" placeholder="Username" v-model="user.username">
          </div>
          <div class="form-group">
            <label class="text-normal text-dark">Password</label>
            <input type="password" class="form-control" placeholder="Password" v-model="user.password">
          </div>
          <div class="form-group">
            <label class="text-normal text-dark">Address</label>
            <input type="text" class="form-control" placeholder="Address" v-model="user.address">
          </div>
          <div class="form-group">
            <div class="peers ai-c jc-sb fxw-nw">
              <div class="peer">
                <button class="btn btn-primary">Register</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
</template>
<script type="text/javascript">
    export default {
        data () {
            return {
                user: {
                    email: '',
                    username: '',
                    password: '',
                    address: ''
                }
            }
        },
        methods: {
            register: function () {
                var app = this;
                axios.post('http://book.com/user', app.user).then(response => {
                    toastr.success(response.data.message);
                    axios.get('http://book.com/auth/admin').then(response => {
                        app.$router.push("/admin");
                    }).catch(errors => {
                        window.location.replace('http://book.com')
                    })
                }).catch(errors => {
                  ErrorHelper.error(errors);
                })
            }
        }
    }
</script>
