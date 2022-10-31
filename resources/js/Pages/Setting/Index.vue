<script setup>
    import { ref } from 'vue'
    import AuthenticatedLayout   from '@/Layouts/AuthenticatedLayout.vue';
    import BABlackdrop           from '@/Components/BABlackdrop.vue';
    import BALoading             from '@/Components/BALoading.vue';
    import { Head, Link }        from '@inertiajs/inertia-vue3';
     
    const props                  = defineProps([
                                        'setting_permits',
                                   ]) 

    const colors                 = ref(['#031643','#a39163'])
    const color_panels           = ref([colors.value[0], colors.value[0], colors.value[0], colors.value[0]])
    const on_loading             = ref(false)


    function sync(){
        on_loading.value  = true
        let data = { 
            'mode' : 'recent'
        }

        axios.post('/setting/sync', data )
            .then((res) => {
                console.log( res.data.message )
                on_loading.value  = false
            })
            .catch((error) => {
                console.log( error )
                on_loading.value  = false
            })
    }

</script>

<template>
    <Head title="Setting" />

    <AuthenticatedLayout :setting_permits="setting_permits">
        
        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl h-[50px] mx-auto px-4 sm:px-6 lg:px-8 flex justify-start items-center space-x-6">
                <h4 class="font-semibold text-xl text-gray-800 ">
                    Setting
                </h4>
            </div>
        </header>

        <!-- Panels -->
        <div class="h-fit flex flex-col max-w-7xl mx-auto my-5 bg-white shadow-md rounded">
            <div class="flex-col">
                <div class="h-[50px] text-[#828282] flex justify-center items-center border-b">
                    System Setting
                </div>
                <div class="h-fit w-full p-3 sm:p-10 flex justify-evenly items-center">
                    <Link :href="route('setting.staff')">
                    <button
                        @mouseleave="color_panels[0]=colors[0]" @mouseover="color_panels[0]=colors[1]" 
                        class="h-[100px] w-[100px] bg-harrow-blue-20 hover:bg-harrow-gold-20 rounded-lg shadow-sm text-harrow-blue-100 hover:text-harrow-gold-100 flex flex-col justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="px-7 py-2" viewBox="0 0 640 512"><!-- users --><path :fill="color_panels[0]" d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm32 32h-64c-17.6 0-33.5 7.1-45.1 18.6 40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64zm-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zm-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4z"/></svg>
                        <p>Staff</p>
                    </button>
                    </Link>
                    <Link :href="route('setting.role')">
                    <button 
                        @mouseleave="color_panels[1]=colors[0]" @mouseover="color_panels[1]=colors[1]" 
                        class="h-[100px] w-[100px] bg-harrow-blue-20 hover:bg-harrow-gold-20 rounded-lg shadow-sm text-harrow-blue-100 hover:text-harrow-gold-100 flex flex-col justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="px-7 py-2" viewBox="0 0 640 512"><!-- scroll --><path :fill="color_panels[1]" d="M48 0C21.53 0 0 21.53 0 48v64c0 8.84 7.16 16 16 16h80V48C96 21.53 74.47 0 48 0zm208 412.57V352h288V96c0-52.94-43.06-96-96-96H111.59C121.74 13.41 128 29.92 128 48v368c0 38.87 34.65 69.65 74.75 63.12C234.22 474 256 444.46 256 412.57zM288 384v32c0 52.93-43.06 96-96 96h336c61.86 0 112-50.14 112-112 0-8.84-7.16-16-16-16H288z"/></svg>
                        <p>Role</p>
                    </button>
                    </Link>
                    <button 
                        @mouseleave="color_panels[2]=colors[0]" @mouseover="color_panels[2]=colors[1]" 
                        class="h-[100px] w-[100px] bg-harrow-blue-20 hover:bg-harrow-gold-20 rounded-lg shadow-sm text-harrow-blue-100 hover:text-harrow-gold-100 flex flex-col justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="px-7 py-2" viewBox="0 0 640 512"><!-- school --><path :fill="color_panels[2]" d="M0 224v272c0 8.84 7.16 16 16 16h80V192H32c-17.67 0-32 14.33-32 32zm360-48h-24v-40c0-4.42-3.58-8-8-8h-16c-4.42 0-8 3.58-8 8v64c0 4.42 3.58 8 8 8h48c4.42 0 8-3.58 8-8v-16c0-4.42-3.58-8-8-8zm137.75-63.96l-160-106.67a32.02 32.02 0 0 0-35.5 0l-160 106.67A32.002 32.002 0 0 0 128 138.66V512h128V368c0-8.84 7.16-16 16-16h96c8.84 0 16 7.16 16 16v144h128V138.67c0-10.7-5.35-20.7-14.25-26.63zM320 256c-44.18 0-80-35.82-80-80s35.82-80 80-80 80 35.82 80 80-35.82 80-80 80zm288-64h-64v320h80c8.84 0 16-7.16 16-16V224c0-17.67-14.33-32-32-32z"/></svg>
                        <p>House</p>
                    </button>
                    <button @click="sync()" 
                        @mouseleave="color_panels[3]=colors[0]" @mouseover="color_panels[3]=colors[1]" 
                        class="h-[100px] w-[100px] bg-harrow-blue-20 hover:bg-harrow-gold-20 rounded-lg shadow-sm text-harrow-blue-100 hover:text-harrow-gold-100 flex flex-col justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="px-7 py-2" viewBox="0 0 512 512"><!-- sync-alt --><path :fill="color_panels[3]" d="M370.72 133.28C339.458 104.008 298.888 87.962 255.848 88c-77.458.068-144.328 53.178-162.791 126.85-1.344 5.363-6.122 9.15-11.651 9.15H24.103c-7.498 0-13.194-6.807-11.807-14.176C33.933 94.924 134.813 8 256 8c66.448 0 126.791 26.136 171.315 68.685L463.03 40.97C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.749zM32 296h134.059c21.382 0 32.09 25.851 16.971 40.971l-41.75 41.75c31.262 29.273 71.835 45.319 114.876 45.28 77.418-.07 144.315-53.144 162.787-126.849 1.344-5.363 6.122-9.15 11.651-9.15h57.304c7.498 0 13.194 6.807 11.807 14.176C478.067 417.076 377.187 504 256 504c-66.448 0-126.791-26.136-171.315-68.685L48.97 471.03C33.851 486.149 8 475.441 8 454.059V320c0-13.255 10.745-24 24-24z"/></svg>
                        <p>Sync</p>
                    </button>
                </div>
            </div>
        </div>

        <!-- Loading Modal -->
        <BALoading v-if="on_loading">
        </BALoading>

        <!-- Backdrop -->
        <BABlackdrop v-if="on_loading">
        </BABlackdrop>

    </AuthenticatedLayout>
</template>
