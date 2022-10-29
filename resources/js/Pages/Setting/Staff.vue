<script setup>
    import { ref } from 'vue'
    import AuthenticatedLayout   from '@/Layouts/AuthenticatedLayout.vue';
    import BABlackdrop           from '@/Components/BABlackdrop.vue';
    import BALoading             from '@/Components/BALoading.vue';
    import { Head, Link }        from '@inertiajs/inertia-vue3';
    import dayjs                 from 'dayjs';
    import relativeTime          from 'dayjs/plugin/relativeTime';

    dayjs.extend(relativeTime);
     
    const props                  = defineProps([
                                        'setting_permits',
                                        'admins',
                                   ]) 
    console.log(props.admins)
</script>

<template>
    <Head title="Setting" />

    <AuthenticatedLayout :setting_permits="setting_permits">
        
        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl h-[50px] mx-auto px-4 sm:px-6 lg:px-8 flex justify-start items-center space-x-6">
                <h4 class="font-semibold text-xl text-gray-800 ">
                    <Link :href="route('setting')" class="hover:text-harrow-gold-100">Setting</Link> / Staff
                </h4>
            </div>
        </header>

        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden flex justify-between items-center">
                    <div class="p-1 text-[#828282] text- font-bold text-center">
                        {{admins.length}} Admins
                    </div>
                    <div class="p-1 ">
                        <button class="w-[181px] h-[34px] rounded-md text-base text-white border border-[#c3c8d2] bg-harrow-blue-100 hover:bg-harrow-blue-90 flex justify-center items-center" 
                        target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 pr-3" viewBox="0 0 640 512"><!-- user-plus --><path fill="#fff" d="M624 208h-64v-64c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v64h-64c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h64v64c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-64h64c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm-400 48c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"/></svg>
                            Add Staff
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panels -->
        
        <!-- Boarder Columns -->
        <div class="flex flex-col h-[78vh] max-w-7xl mx-auto sm:pl-6 sm:pr-6 lg:pl-8 ">
            <div class="w-full flex-grow overflow-auto rounded">
                <table class="relative table-fixed border-collapse w-fit">
                    <thead class="sticky top-0" :style="'z-index:'+(admins.length+1)">
                        <tr class="h-[27px] sticky top-[31px] flex border-stroke-gray-1 border-b" 
                            :style="['z-index:'+(admins.length+1)]"
                        >
                            <td 
                                class="w-10 h-full sticky text-sm flex justify-center items-center text-info-gray-2 bg-harrow-gold-20 border-l border-b border-r" :style="'z-index:'+(admins.length+2)"
                            >
                                <p class="font-bold pt-1">#</p>
                            </td>
                            <td 
                                class="w-[304px] h-full sticky text-sm flex justify-center items-center text-info-gray-2 bg-harrow-gold-20 border-l border-b" :style="'z-index:'+(admins.length+2)"
                            >
                                <div class="flex w-auto justify-center items-center">
                                    <p class="font-bold ml-1 pt-[2px]">Name</p>
                                </div>
                            </td>
                            <td 
                                class="w-[155px] h-full sticky text-sm flex justify-center items-center text-info-gray-2 bg-harrow-gold-20 border-b" :style="'z-index:'+(admins.length+2)"
                            >
                                <div class="flex w-auto justify-center items-center">
                                    <p class="font-bold ml-1 pt-[2px]">Role</p>
                                </div>
                            </td>
                            <td 
                                class="w-[155px] h-full sticky pt-1 text-sm flex justify-center items-center text-info-gray-2 bg-harrow-gold-20 border-b border-r" :style="'z-index:'+(admins.length+2)"
                            >
                                <div class="flex w-auto justify-center items-center">
                                    <p class="font-bold ml-1 pt-[2px]">Last Active</p>
                                </div>
                            </td>
                            <td 
                                class="w-[155px] h-full sticky pt-1 text-sm flex justify-center items-center text-info-gray-2 bg-harrow-gold-20 border-b border-r" :style="'z-index:'+(admins.length+2)"
                            >
                                <div class="flex w-auto justify-center items-center">
                                    <p class="font-bold ml-1 pt-[2px]">Status</p>
                                </div>
                            </td>
                            <td 
                                class="w-[79px] h-full sticky pt-1 text-sm flex justify-center items-center text-info-gray-2 bg-harrow-gold-20 border-b border-r" :style="'z-index:'+(admins.length+2)"
                            >
                                <div class="flex w-auto justify-center items-center">
                                    <p class="font-bold ml-1 pt-[2px]"></p>
                                </div>
                            </td>

                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data -->
                        <tr v-for="(admin, index) in admins" :key="admin.pupil_id" class="flex h-[56px] bg-white hover:bg-gray-50" :style="['z-index:'+(admins.length-index)]">
                            <td class="w-10 text-sm text-center flex justify-center items-center text-info-gray-2 border-b" >
                                {{index+1}}
                            </td>
                            <td 
                                class="w-[304px] text-sm text-info-gray-2 border-l border-b  flex justify-center items-center"
                            >  
                                <div class="pr-0 flex justify-center items-center w-full">
                                    <img class="object-cover object-top w-10 h-10 bg-slate-50 rounded-full mr-2.5 " :src="!admin.photo? '/images/anonymous.png' : 'data:image/png;base64,' +  admin.photo" />
                                    <div class="text-left flex-col w-3/4">
                                        <div class="font-bold truncate">{{admin.name}}</div>
                                        <div class="text-info-gray-1">{{admin.email}}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[155px] text-sm text-center flex justify-center items-center text-info-gray-2 border-b" >
                                {{admin.role_name}}
                            </td>
                            <td class="w-[155px] text-sm text-center flex justify-center items-center text-info-gray-2 border-b" >
                                {{!admin.last_login ? '-' : dayjs(admin.last_login).fromNow() }}
                            </td>
                            <td class="w-[155px] text-sm text-center flex justify-center items-center text-info-gray-2 border-b">
                                <div v-if="admin.is_blocked" class="p-2 rounded text-info-gray-1 bg-fill-gray-2">BLOCKED</div>
                                <div v-else></div>
                            </td>
                            <td class="w-[79px] text-sm text-center flex justify-center items-center text-info-gray-2 border-b border-r">
                                    <button @click="assign_boarder(admin)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 ml-1 p-0"><path fill="#a39163" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM325.8 139.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-21.4 21.4-71-71 21.4-21.4c15.6-15.6 40.9-15.6 56.6 0zM119.9 289L225.1 183.8l71 71L190.9 359.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z"/></svg>
                                    </button>
                            </td>

                        </tr>                        
                    </tbody>
                </table>
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
