<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaSwitch from '@/Components/BASwitch.vue';
import BAHeaderA from '@/Components/BAHeaderA.vue';
import BAHeaderB from '@/Components/BAHeaderB.vue';
import BARegister from '@/Components/BARegister.vue';
import BAAttendMIS from '@/Components/BAAttendMIS.vue';
import { useForm, Head } from '@inertiajs/inertia-vue3';

const on_weekly = ref(false)
const on_mis_data = ref(false)

const props = defineProps(['boarders']);

    // console.log( props.boarder.year_group )

</script>

<template>
    <Head title="Registration" />

    <AuthenticatedLayout>
        <!-- <template #header>
            <h4 class="font-semibold text-xl text-gray-800 leading-tight">
                Registration
            </h4>
        </template> -->
        
        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl h-[50px] mx-auto px-4 sm:px-6 lg:px-8 flex justify-start items-center space-x-6">
                <h4 class="font-semibold text-xl text-gray-800 ">
                    Registration
                </h4>
                <div class="flex justify-start items-center h-full">
                    <div class="text-gray-400 text-sm mr-1">Building:</div>
                    <button class="border-stroke-gray-3 border ml-1 pl-1 w-36 h-[38px] rounded-md flex justify-evenly items-center relative">
                        <p class="w-3/4 flex justify-start ">West Acre</p>
                        <div class="flex justify-end">
                            <div class="w-2 h-2 text-right">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#828282" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                            </div>
                        </div>
                        <div class="absolute top-[37px] left-0 z-30 w-36 shadow-md border border-t-0 border-stroke-gray-3 rounded-b-md overflow-clip bg-fill-gray-2">
                            <div class="border-stroke-gray-3 h-[38px] flex pl-3 items-center border-b">All</div>
                            <div class="border-stroke-gray-3 h-[38px] flex pl-3 items-center border-b">Bradbys</div>
                            <div class="border-stroke-gray-3 h-[38px] flex pl-3 items-center border-b">Junior Girls</div>
                            <div class="border-stroke-gray-3 h-[38px] flex pl-3 items-center border-b">The Grove</div>
                            <div class="border-stroke-gray-3 h-[38px] flex pl-3 items-center">West Acre</div>
                        </div>
                    </button>                    
                </div>
                <div class="flex justify-start items-center">
                    <div class="text-gray-400 text-sm">Week:</div>
                    <div class="flex justify-evenly items-center">
                        <div class="pt-1 mx-2 ">
                            <button class="w-5 h-5 shadow-md rounded-full border-2 bg-white hover:bg-harrow-gold-20">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#828282" d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256S114.6 512 256 512s256-114.6 256-256zM116.7 244.7l112-112c4.6-4.6 11.5-5.9 17.4-3.5s9.9 8.3 9.9 14.8l0 64 96 0c17.7 0 32 14.3 32 32l0 32c0 17.7-14.3 32-32 32l-96 0 0 64c0 6.5-3.9 12.3-9.9 14.8s-12.9 1.1-17.4-3.5l-112-112c-6.2-6.2-6.2-16.4 0-22.6z"/></svg>
                            </button>
                        </div>
                        <p class="w-[320px] text-base text-center font-bold text-harrow-gold-100">12 September 2022 - 18 September 2022</p>
                        <div class="pt-1 mx-2 ">
                            <button class="w-5 h-5 shadow-md rounded-full border-2 bg-white hover:bg-harrow-gold-20">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#828282" d="M0 256C0 397.4 114.6 512 256 512s256-114.6 256-256S397.4 0 256 0S0 114.6 0 256zm395.3 11.3l-112 112c-4.6 4.6-11.5 5.9-17.4 3.5s-9.9-8.3-9.9-14.8l0-64-96 0c-17.7 0-32-14.3-32-32l0-32c0-17.7 14.3-32 32-32l96 0 0-64c0-6.5 3.9-12.3 9.9-14.8s12.9-1.1 17.4 3.5l112 112c6.2 6.2 6.2 16.4 0 22.6z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <BaSwitch :is-on="on_weekly" label="Weekly" @toggle="(value) => on_weekly = value" />
                <BaSwitch :is-on="on_mis_data" :label="'Show Attendance From ' + $page.props.app.mis" @toggle="on_mis_data=$event" />
            </div>
        </header>

        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden ">
                    <div class="p-1 text-[#828282] text- font-bold text-center">
                        2022-23 Term 1 ( Week 5 )
                    </div>
                </div>
            </div>
        </div>

        <!-- Boarder Columns -->
        <div class="flex flex-col h-[73vh] max-w-7xl mx-auto sm:pl-6 sm:pr-6 lg:pl-8 ">
            <div class="w-full flex-grow overflow-auto rounded" :class="on_mis_data ? '  border-harrow-gold-100' : ''">
                <table class="relative table-fixed border-collapse " :class="on_mis_data? 'w-[1484px]': 'w-[1084px]'">
                    <thead class="sticky top-0 z-10">
                        <tr class="h-[31px] text-sm text-info-gray-1 flex" :class="on_mis_data? 'w-[1484px]': 'w-[1084px]'">
                            <th colspan="3"  class="w-[424px] sticky top-0 left-0 z-40 font-normal text-center bg-fill-gray-1 border border-stroke-gray-1 flex justify-center items-center">
                                {{boarders.length}} Boarders
                            </th>
                            <th colspan="12" class="sticky top-0 font-normal text-center bg-fill-gray-3 border border-stroke-gray-2 flex justify-center items-center"  :class="on_mis_data? 'w-[528px]': 'w-[328px]'">
                                Monday ( 3 Oct 2022 )
                            </th>
                            <th colspan="12" class="sticky top-0 font-normal text-center bg-fill-gray-2 border border-stroke-gray-2 flex justify-center items-center"  :class="on_mis_data? 'w-[528px]': 'w-[328px]'">
                                Tuesday ( 4 Oct 2022 )
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class=" sticky top-[31px] z-10 flex border-stroke-gray-1 " :class="on_mis_data? 'h-[66px] w-[1484px]': 'h-[31px] w-[1084px]'">
                            <td class="w-[232px] h-full sticky left-0 z-20 text-sm flex justify-center items-center text-info-gray-2 bg-fill-gray-1 border-l border-b">
                                <div class="flex w-auto justify-center items-center">
                                    <!-- user-alt -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-[15px] h-[15px]"><path fill="#4F4F4F" d="M256 288c79.5 0 144-64.5 144-144S335.5 0 256 0S112 64.5 112 144s64.5 144 144 144zm-94.7 32C72.2 320 0 392.2 0 481.3c0 17 13.8 30.7 30.7 30.7H481.3c17 0 30.7-13.8 30.7-30.7C512 392.2 439.8 320 350.7 320H161.3z"/></svg>
                                    <p class="font-bold ml-1 pt-[2px]">Name</p>
                                </div>
                            </td>
                            <td class="w-[114px] h-full sticky left-[232px] z-20 text-sm flex justify-center items-center text-info-gray-2 bg-fill-gray-1 border-b">
                                <div class="flex w-auto justify-center items-center">
                                    <!-- home -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-[18px] h-[18px]"><path fill="#4F4F4F" d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z"/></svg>
                                    <p class="font-bold ml-1 pt-[2px]">Building</p>
                                </div>
                            </td>
                            <td class="w-[78px] h-full sticky left-[346px] z-20 pt-1 text-sm flex justify-center items-center text-info-gray-2 bg-fill-gray-1 border-b border-r">
                                <div class="flex w-auto justify-center items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="w-[18px] h-[18px]"><path fill="#4F4F4F" d="M184 48H328c4.4 0 8 3.6 8 8V96H176V56c0-4.4 3.6-8 8-8zm-56 8V96H64C28.7 96 0 124.7 0 160v96H192 352h8.2c32.3-39.1 81.1-64 135.8-64c5.4 0 10.7 .2 16 .7V160c0-35.3-28.7-64-64-64H384V56c0-30.9-25.1-56-56-56H184c-30.9 0-56 25.1-56 56zM320 352H224c-17.7 0-32-14.3-32-32V288H0V416c0 35.3 28.7 64 64 64H360.2C335.1 449.6 320 410.5 320 368c0-5.4 .2-10.7 .7-16l-.7 0zm320 16c0-79.5-64.5-144-144-144s-144 64.5-144 144s64.5 144 144 144s144-64.5 144-144zM496 288c8.8 0 16 7.2 16 16v48h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H496c-8.8 0-16-7.2-16-16V304c0-8.8 7.2-16 16-16z"/></svg>
                                    <p class="font-bold ml-1 pt-[2px]">Type</p>
                                </div>
                            </td>

                            <BAHeaderA>Morning 0715</BAHeaderA>
                            <BAHeaderA>Callover 1740</BAHeaderA>
                            <BAHeaderB :class="on_mis_data ? '' : 'hidden' ">Morning</BAHeaderB>
                            <BAHeaderB :class="on_mis_data ? '' : 'hidden' ">Afternoon</BAHeaderB>
                            <BAHeaderB :class="on_mis_data ? '' : 'hidden' ">Reg</BAHeaderB>
                            <BAHeaderB :class="on_mis_data ? '' : 'hidden' ">Lesson 1</BAHeaderB>
                            <BAHeaderB :class="on_mis_data ? '' : 'hidden' ">Lesson 2</BAHeaderB>
                            <BAHeaderB :class="on_mis_data ? '' : 'hidden' ">Lesson 3</BAHeaderB>
                            <BAHeaderB :class="on_mis_data ? '' : 'hidden' ">Lesson 4</BAHeaderB>
                            <BAHeaderB :class="on_mis_data ? '' : 'hidden' ">Lesson 5</BAHeaderB>
                            <BAHeaderA>Bed</BAHeaderA>
                            <BAHeaderA>Offsite Status</BAHeaderA>

                            <BAHeaderA>Morning 0715</BAHeaderA>
                            <BAHeaderA>Callover 1740</BAHeaderA>
                            <BAHeaderB :class="on_mis_data ? '' : 'hidden' ">Morning</BAHeaderB>
                            <BAHeaderB :class="on_mis_data ? '' : 'hidden' ">Afternoon</BAHeaderB>
                            <BAHeaderB :class="on_mis_data ? '' : 'hidden' ">Reg</BAHeaderB>
                            <BAHeaderB :class="on_mis_data ? '' : 'hidden' ">Lesson 1</BAHeaderB>
                            <BAHeaderB :class="on_mis_data ? '' : 'hidden' ">Lesson 2</BAHeaderB>
                            <BAHeaderB :class="on_mis_data ? '' : 'hidden' ">Lesson 3</BAHeaderB>
                            <BAHeaderB :class="on_mis_data ? '' : 'hidden' ">Lesson 4</BAHeaderB>
                            <BAHeaderB :class="on_mis_data ? '' : 'hidden' ">Lesson 5</BAHeaderB>
                            <BAHeaderA>Bed</BAHeaderA>
                            <BAHeaderA class="border-r">Offsite Status</BAHeaderA>

                        </tr>


                        <!-- Data -->
                        <tr v-for="boarder in boarders" :key="boarder.pupil_id" class="sticky inline-flex border-b h-[66px]" :class="on_mis_data? 'w-[1484px]': 'w-[1084px]'">
                            <td class="w-[232px] sticky left-0 z-20 pt-1 text-sm text-info-gray-2 border-l bg-fill-gray-1">  
                                <div class="p-2.5 pr-0 flex justify-center items-center">
                                    <img class="object-cover object-top w-10 h-10 bg-slate-300 rounded-full mr-2.5 " :src="'data:image/png;base64,' +  boarder.photo" />
                                    <div class="text-left flex-col w-[145px]">
                                        <div class="font-bold truncate">{{boarder.prefered_forename+' '+boarder.surname}}</div>
                                        <div class="text-info-gray-1">{{boarder.year_group}}, {{boarder.form}}, {{boarder.gender=='M'?'Male':'Female'}}</div>
                                    </div>
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 ml-1 p-0"><path fill="#a39163" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM325.8 139.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-21.4 21.4-71-71 21.4-21.4c15.6-15.6 40.9-15.6 56.6 0zM119.9 289L225.1 183.8l71 71L190.9 359.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z"/></svg>
                                    </button>
                                </div>
                            </td>
                            <td class="w-[114px] sticky left-[232px] z-20 pt-1 text-sm text-center flex justify-center items-center text-info-gray-2 bg-fill-gray-1">
                                {{boarder.building_name}}
                            </td>
                            <td class="w-[78px] sticky left-[346px] z-20 pt-1 text-sm text-center flex justify-center items-center text-info-gray-2 bg-fill-gray-1  border-r">
                                {{boarder.boarder_type}}
                            </td>


                            <BARegister></BARegister>
                            <BARegister></BARegister>
                            <BAAttendMIS :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            <BAAttendMIS :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            <BAAttendMIS :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            <BAAttendMIS :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            <BAAttendMIS :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            <BAAttendMIS :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            <BAAttendMIS :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            <BAAttendMIS :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            <BARegister></BARegister>
                            <BARegister></BARegister>


                            <BARegister></BARegister>
                            <BARegister></BARegister>
                            <BAAttendMIS :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            <BAAttendMIS :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            <BAAttendMIS :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            <BAAttendMIS :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            <BAAttendMIS :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            <BAAttendMIS :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            <BAAttendMIS :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            <BAAttendMIS :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            <BARegister></BARegister>
                            <BARegister class="border-r"></BARegister>

                        </tr>
                        
                    </tbody>
                </table>
            </div>
            
        </div>
    </AuthenticatedLayout>
</template>
