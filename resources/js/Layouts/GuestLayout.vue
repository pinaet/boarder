<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
const appUrl = usePage().props.value.appUrl
</script>

<template>
    <div class="h-[720px] w-auto flex flex-col items-center pt-6 sm:pt-0 bg-harrow-blue-100 [background:url('images/gray-geometric-pattern.jpg')_center_/_cover]">
        <Head>
            <link rel="icon" type="image/x-icon" :href="appUrl+'/images/HIS_Bangkok_VERTICAL_ENG_BLUE_square.png'" />
        </Head>
        <slot />

        <!-- <div>  sm:justify-center
            <Link href="/">
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div> -->
    </div>
</template>
