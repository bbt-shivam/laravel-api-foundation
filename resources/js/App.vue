<template>
    <div>
        <div>
            <router-link class="text-success" to="/">Home</router-link>
        </div>
        <div>
            <router-link to="/about">About</router-link>
        </div>
        <router-view />
    </div>
</template>