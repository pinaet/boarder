<script setup>
    import { ref } from 'vue'
    import AuthenticatedLayout   from '@/Layouts/AuthenticatedLayout.vue';
    import BABlackdrop           from '@/Components/BABlackdrop.vue';
    import BALoading             from '@/Components/BALoading.vue';
    import { Head }              from '@inertiajs/inertia-vue3';
     
    const props                  = defineProps([
                                        'setting_permits',
                                   ]) 

</script>

<template>
    <Head title="Setting" />

    <AuthenticatedLayout :setting_permits="setting_permits">
        
        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl h-[50px] mx-auto px-4 sm:px-6 lg:px-8 flex justify-start items-center space-x-6">
                <h4 class="font-semibold text-xl text-gray-800 ">
                    Setting > Staff
                </h4>
            </div>
        </header>

        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden ">
                    <div class="p-1 ">
                        <a class="w-[181px] h-[29px] rounded-md font-bold text-white border border-[#c3c8d2] bg-harrow-blue-100 flex justify-center items-center" 
                        target="_blank">
                        <!-- briefcase -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-2 mr-2" viewBox="0 0 512 512"><path fill="white" d="M320 336c0 8.84-7.16 16-16 16h-96c-8.84 0-16-7.16-16-16v-48H0v144c0 25.6 22.4 48 48 48h416c25.6 0 48-22.4 48-48V288H320v48zm144-208h-80V80c0-25.6-22.4-48-48-48H176c-25.6 0-48 22.4-48 48v48H48c-25.6 0-48 22.4-48 48v80h512v-80c0-25.6-22.4-48-48-48zm-144 0H192V96h128v32z"/></svg>
                            Absence Request
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panels -->
        <div class="h-fit flex flex-col max-w-7xl mx-auto my-5 bg-white shadow-md rounded">
            <div class="flex-col">
                <div class="h-[50px] text-[#828282] flex justify-center items-center border-b">
                    Staff Setting
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
