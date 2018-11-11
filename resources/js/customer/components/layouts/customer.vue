<template>
    <div>
        <Header></Header>
        <transition name="slide">
            <router-view></router-view>
        </transition>
        <Footer></Footer>
    </div>
</template>

<script>
    import Header from './partials/header'
    import Footer from './partials/footer'
    export default {
        data () {
            return {

            }
        },
        methods: {
            
        },
        components: {Header, Footer}
    }
</script>
