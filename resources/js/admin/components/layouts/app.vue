<template>
    <div>
        <app-sidebar></app-sidebar>
        <div class="page-container">
            <app-header></app-header>
            <main class="main-content bgc-grey-100">
                <div id="mainContent">
                    <transition name="slide">
                        <router-view></router-view>
                    </transition>
                </div>
            </main>
            <app-footer></app-footer>
        </div>
    </div>
</template>
