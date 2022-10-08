<script setup>
import { ref, toRef } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaSwitch from '@/Components/BASwitch.vue';
import { Head } from '@inertiajs/inertia-vue3';

const on_weekly = ref(false)
const on_mis_data = ref(false)

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
                    <button class="border-gray-600 border ml-1 pl-1 w-36 h-[38px] rounded-md flex justify-evenly items-center">
                        <p class="w-3/4 flex justify-start ">West Acre</p>
                        <div class="flex justify-end">
                            <div class="w-2 h-2 text-right">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#828282" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                            </div>
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
            <div class="w-full flex-grow overflow-auto ">
                <table class="relative table-fixed border-collapse" :class="on_mis_data? 'w-[1484px]': 'w-[1084px]'">
                    <thead>
                        <tr class="h-[31px] sticky top-0 z-10 text-sm text-info-gray-1 shadow-sm" :class="on_mis_data? 'w-[1484px]': 'w-[1084px]'">
                            <th colspan="3"  class="w-[424px] sticky left-0 z-20 font-normal bg-fill-gray-1 border border-stroke-gray-1 text-center">
                                7 Boarders
                            </th>
                            <th colspan="12" class=" font-normal bg-fill-gray-3 border border-stroke-gray-2 text-center"  :class="on_mis_data? 'w-[528px]': 'w-[328px]'">
                                Monday ( 3 Oct 2022 )
                            </th>
                            <th colspan="12" class=" font-normal bg-fill-gray-2 border border-stroke-gray-2 text-center"  :class="on_mis_data? 'w-[528px]': 'w-[328px]'">
                                Tuesday ( 4 Oct 2022 )
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-fill-gray-1 sticky top-[31px] z-10 shadow-sm inline-flex border-b" :class="on_mis_data? 'h-[66px] w-[1484px]': 'h-[31px] w-[1084px]'">
                            <td class="w-[232px] sticky left-0 z-20 pt-1 text-sm text-center text-info-gray-2 bg-fill-gray-1 border-l">  
                                <div class="inline-block" :class="on_mis_data ? 'pt-4' : '-pt-[3px]' ">
                                    <div class="pt-[1px] pl-1 flex ">
                                        <div class="w-3.5 h-3.5 pt-1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#4F4F4F" d="M256 288c79.5 0 144-64.5 144-144S335.5 0 256 0S112 64.5 112 144s64.5 144 144 144zm-94.7 32C72.2 320 0 392.2 0 481.3c0 17 13.8 30.7 30.7 30.7H481.3c17 0 30.7-13.8 30.7-30.7C512 392.2 439.8 320 350.7 320H161.3z"/></svg></div>
                                        <p class="font-bold ml-1 pt-[2px]">Name</p>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[114px] sticky left-[232px] z-20 pt-1 text-sm text-center text-info-gray-2 bg-fill-gray-1  ">
                                <div class="inline-block" :class="on_mis_data ? 'pt-4' : '-pt-[3px]' ">
                                    <div class="pt-[1px] pl-1 flex ">
                                        <div class="w-3.5 h-3.5 pt-1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#4F4F4F" d="M543.8 287.6c17 0 32-14 32-32.1c1-9-3-17-11-24L512 185V64c0-17.7-14.3-32-32-32H448c-17.7 0-32 14.3-32 32v36.7L309.5 7c-6-5-14-7-21-7s-15 1-22 8L10 231.5c-7 7-10 15-10 24c0 18 14 32.1 32 32.1h32v69.7c-.1 .9-.1 1.8-.1 2.8V472c0 22.1 17.9 40 40 40h16c1.2 0 2.4-.1 3.6-.2c1.5 .1 3 .2 4.5 .2H160h24c22.1 0 40-17.9 40-40V448 384c0-17.7 14.3-32 32-32h64c17.7 0 32 14.3 32 32v64 24c0 22.1 17.9 40 40 40h24 32.5c1.4 0 2.8 0 4.2-.1c1.1 .1 2.2 .1 3.3 .1h16c22.1 0 40-17.9 40-40V455.8c.3-2.6 .5-5.3 .5-8.1l-.7-160.2h32z"/></svg></div>
                                        <p class="font-bold ml-1 pt-[2px]">Building</p>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[78px] sticky left-[346px] z-20 pt-1 text-sm text-center text-info-gray-2 bg-fill-gray-1  border-r">
                                <div class="inline-block" :class="on_mis_data ? 'pt-4' : '-pt-[3px]' ">
                                    <div class="pt-[1px] pl-1 flex ">
                                        <div class="w-4 h-4 pt-[5px]"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="#4F4F4F" d="M184 48H328c4.4 0 8 3.6 8 8V96H176V56c0-4.4 3.6-8 8-8zm-56 8V96H64C28.7 96 0 124.7 0 160v96H192 352h8.2c32.3-39.1 81.1-64 135.8-64c5.4 0 10.7 .2 16 .7V160c0-35.3-28.7-64-64-64H384V56c0-30.9-25.1-56-56-56H184c-30.9 0-56 25.1-56 56zM320 352H224c-17.7 0-32-14.3-32-32V288H0V416c0 35.3 28.7 64 64 64H360.2C335.1 449.6 320 410.5 320 368c0-5.4 .2-10.7 .7-16l-.7 0zm320 16c0-79.5-64.5-144-144-144s-144 64.5-144 144s64.5 144 144 144s144-64.5 144-144zM496 288c8.8 0 16 7.2 16 16v48h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H496c-8.8 0-16-7.2-16-16V304c0-8.8 7.2-16 16-16z"/></svg></div>
                                        <p class="font-bold ml-1 pt-[2px]">Type</p>
                                    </div>
                                </div>
                            </td>


                            <td class="w-[82px] text-xs text-center underline px-1 border-l" :class="on_mis_data ? 'pt-4' : '-pt-[3px]' ">
                                Morning 0715
                            </td>
                            <td class="w-[82px] text-xs text-center underline px-1 border-l" :class="on_mis_data ? 'pt-4' : '-mt-[3px]' ">
                                Callover 1740
                            </td>
                            <td class="w-[25px] text-xs text-center underline px-1 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-7">Morning</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-5 mt-6">Afternoon</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-7">Reg</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 1</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 2</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 3</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 4</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 5</span></td>
                            <td class="w-[82px] text-xs text-center underline px-1 border-l" :class="on_mis_data ? 'pt-4' : '-pt-[3px]' ">Bed</td>
                            <td class="w-[82px] text-xs text-center underline px-1 border-l" :class="on_mis_data ? 'pt-4' : '-pt-[3px]' ">Offsite Status</td>


                            <td class="w-[82px] text-xs text-center underline px-1 border-l" :class="on_mis_data ? 'pt-4' : '-pt-[3px]' ">
                                Morning 0715
                            </td>
                            <td class="w-[82px] text-xs text-center underline px-1 border-l" :class="on_mis_data ? 'pt-4' : '-mt-[3px]' ">
                                Callover 1740
                            </td>
                            <td class="w-[25px] text-xs text-center underline px-1 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-7">Morning</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-5 mt-6">Afternoon</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-7">Reg</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 1</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 2</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 3</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 4</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 5</span></td>
                            <td class="w-[82px] text-xs text-center underline px-1 border-l" :class="on_mis_data ? 'pt-4' : '-pt-[3px]' ">Bed</td>
                            <td class="w-[82px] text-xs text-center underline px-1 border-l" :class="on_mis_data ? 'pt-4' : '-pt-[3px]' ">Offsite Status</td>

                        </tr>


                        <!-- Data -->
                        <tr class="bg-fill-gray-1 sticky shadow-sm inline-flex border-b h-[66px]" :class="on_mis_data? 'w-[1484px]': 'w-[1084px]'">
                            <td class="w-[232px] sticky left-0 z-20 pt-1 text-sm text-center text-info-gray-2 border-l bg-fill-gray-1">  
                                <div class="" >
                                    <div class="p-2.5 pr-0 flex">
                                        <div class="w-10 h-10 bg-slate-300 rounded-full mr-2.5">P</div>
                                        <div class="text-left flex-col">
                                            <div class="font-bold">Pinaet Poonsarakhun</div>
                                            <div class="text-info-gray-1">Y10, C10, Female</div>
                                        </div>
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 ml-2.5 p-0"><path fill="#a39163" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM325.8 139.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-21.4 21.4-71-71 21.4-21.4c15.6-15.6 40.9-15.6 56.6 0zM119.9 289L225.1 183.8l71 71L190.9 359.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[114px] sticky left-[232px] z-20 pt-1 text-sm flex justify-center items-center text-info-gray-2 bg-fill-gray-1">
                                West Acre
                            </td>
                            <td class="w-[78px] sticky left-[346px] z-20 pt-1 text-sm flex justify-center items-center text-info-gray-2 bg-fill-gray-1  border-r">
                                Full
                            </td>


                            <td class="w-[82px] border-l">
                                <div class="w-full h-full text-xs p-1 flex items-center justify-evenly space-x-1">
                                    <div class="bg-note-gray-1 w-[40px] h-[26px] rounded-md px-1 flex items-center justify-evenly space-x-1">
                                        <div class="w-[25px] flex justify-center items-center h-full ">
                                            -
                                        </div>
                                        <div class="w-[15px] flex justify-end items-center h-full ">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-2.5 h-2.5"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"/></svg>
                                        </div>
                                    </div>
                                    <div class="bg-note-gray-1 w-[26px] h-[26px] rounded-md flex justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4"><path fill="#BDBDBD" d="M312 320h136V56c0-13.3-10.7-24-24-24H24C10.7 32 0 42.7 0 56v400c0 13.3 10.7 24 24 24h264V344c0-13.2 10.8-24 24-24zm129 55l-98 98c-4.5 4.5-10.6 7-17 7h-6V352h128v6.1c0 6.3-2.5 12.4-7 16.9z"/></svg>
                                    </div>
                                </div>
                            </td>


                            
                            <td class="w-[82px] border-l">
                                <div class="w-full h-full text-xs p-1 flex items-center justify-evenly space-x-1">
                                    <div class="bg-note-gray-1 w-[40px] h-[26px] rounded-md px-1 flex items-center justify-evenly space-x-1">
                                        <div class="w-[25px] flex justify-center items-center h-full ">
                                            -
                                        </div>
                                        <div class="w-[15px] flex justify-end items-center h-full ">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-2.5 h-2.5"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"/></svg>
                                        </div>
                                    </div>
                                    <div class="bg-note-gray-1 w-[26px] h-[26px] rounded-md flex justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4"><path fill="#BDBDBD" d="M312 320h136V56c0-13.3-10.7-24-24-24H24C10.7 32 0 42.7 0 56v400c0 13.3 10.7 24 24 24h264V344c0-13.2 10.8-24 24-24zm129 55l-98 98c-4.5 4.5-10.6 7-17 7h-6V352h128v6.1c0 6.3-2.5 12.4-7 16.9z"/></svg>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[25px] text-xs text-center underline px-1 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-7">Morning</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-5 mt-6">Afternoon</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-7">Reg</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 1</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 2</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 3</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 4</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 5</span></td>
                            <td class="w-[82px] border-l">
                                <div class="w-full h-full text-xs p-1 flex items-center justify-evenly space-x-1">
                                    <div class="bg-note-gray-1 w-[40px] h-[26px] rounded-md px-1 flex items-center justify-evenly space-x-1">
                                        <div class="w-[25px] flex justify-center items-center h-full ">
                                            -
                                        </div>
                                        <div class="w-[15px] flex justify-end items-center h-full ">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-2.5 h-2.5"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"/></svg>
                                        </div>
                                    </div>
                                    <div class="bg-note-gray-1 w-[26px] h-[26px] rounded-md flex justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4"><path fill="#BDBDBD" d="M312 320h136V56c0-13.3-10.7-24-24-24H24C10.7 32 0 42.7 0 56v400c0 13.3 10.7 24 24 24h264V344c0-13.2 10.8-24 24-24zm129 55l-98 98c-4.5 4.5-10.6 7-17 7h-6V352h128v6.1c0 6.3-2.5 12.4-7 16.9z"/></svg>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[82px] border-l">
                                <div class="w-full h-full text-xs p-1 flex items-center justify-evenly space-x-1">
                                    <div class="bg-note-gray-1 w-[40px] h-[26px] rounded-md px-1 flex items-center justify-evenly space-x-1">
                                        <div class="w-[25px] flex justify-center items-center h-full ">
                                            -
                                        </div>
                                        <div class="w-[15px] flex justify-end items-center h-full ">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-2.5 h-2.5"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"/></svg>
                                        </div>
                                    </div>
                                    <div class="bg-note-gray-1 w-[26px] h-[26px] rounded-md flex justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4"><path fill="#BDBDBD" d="M312 320h136V56c0-13.3-10.7-24-24-24H24C10.7 32 0 42.7 0 56v400c0 13.3 10.7 24 24 24h264V344c0-13.2 10.8-24 24-24zm129 55l-98 98c-4.5 4.5-10.6 7-17 7h-6V352h128v6.1c0 6.3-2.5 12.4-7 16.9z"/></svg>
                                    </div>
                                </div>
                            </td>


                            
                            <td class="w-[82px] border-l">
                                <div class="w-full h-full text-xs p-1 flex items-center justify-evenly space-x-1">
                                    <div class="bg-note-gray-1 w-[40px] h-[26px] rounded-md px-1 flex items-center justify-evenly space-x-1">
                                        <div class="w-[25px] flex justify-center items-center h-full ">
                                            -
                                        </div>
                                        <div class="w-[15px] flex justify-end items-center h-full ">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-2.5 h-2.5"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"/></svg>
                                        </div>
                                    </div>
                                    <div class="bg-note-gray-1 w-[26px] h-[26px] rounded-md flex justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4"><path fill="#BDBDBD" d="M312 320h136V56c0-13.3-10.7-24-24-24H24C10.7 32 0 42.7 0 56v400c0 13.3 10.7 24 24 24h264V344c0-13.2 10.8-24 24-24zm129 55l-98 98c-4.5 4.5-10.6 7-17 7h-6V352h128v6.1c0 6.3-2.5 12.4-7 16.9z"/></svg>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[82px] border-l">
                                <div class="w-full h-full text-xs p-1 flex items-center justify-evenly space-x-1">
                                    <div class="bg-note-gray-1 w-[40px] h-[26px] rounded-md px-1 flex items-center justify-evenly space-x-1">
                                        <div class="w-[25px] flex justify-center items-center h-full ">
                                            -
                                        </div>
                                        <div class="w-[15px] flex justify-end items-center h-full ">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-2.5 h-2.5"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"/></svg>
                                        </div>
                                    </div>
                                    <div class="bg-note-gray-1 w-[26px] h-[26px] rounded-md flex justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4"><path fill="#BDBDBD" d="M312 320h136V56c0-13.3-10.7-24-24-24H24C10.7 32 0 42.7 0 56v400c0 13.3 10.7 24 24 24h264V344c0-13.2 10.8-24 24-24zm129 55l-98 98c-4.5 4.5-10.6 7-17 7h-6V352h128v6.1c0 6.3-2.5 12.4-7 16.9z"/></svg>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[25px] text-xs text-center underline px-1 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-7">Morning</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-5 mt-6">Afternoon</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-7">Reg</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 1</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 2</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 3</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 4</span></td>
                            <td class="w-[25px] text-xs text-center underline px-0 -pt-[3px] border-l" :class="on_mis_data ? '' : 'hidden' "><span class="inline-block -rotate-90 -m-4 mt-6">Lession 5</span></td>
                            <td class="w-[82px] border-l">
                                <div class="w-full h-full text-xs p-1 flex items-center justify-evenly space-x-1">
                                    <div class="bg-note-gray-1 w-[40px] h-[26px] rounded-md px-1 flex items-center justify-evenly space-x-1">
                                        <div class="w-[25px] flex justify-center items-center h-full ">
                                            -
                                        </div>
                                        <div class="w-[15px] flex justify-end items-center h-full ">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-2.5 h-2.5"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"/></svg>
                                        </div>
                                    </div>
                                    <div class="bg-note-gray-1 w-[26px] h-[26px] rounded-md flex justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4"><path fill="#BDBDBD" d="M312 320h136V56c0-13.3-10.7-24-24-24H24C10.7 32 0 42.7 0 56v400c0 13.3 10.7 24 24 24h264V344c0-13.2 10.8-24 24-24zm129 55l-98 98c-4.5 4.5-10.6 7-17 7h-6V352h128v6.1c0 6.3-2.5 12.4-7 16.9z"/></svg>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[82px] border-l">
                                <div class="w-full h-full text-xs p-1 flex items-center justify-evenly space-x-1">
                                    <div class="bg-note-gray-1 w-[40px] h-[26px] rounded-md px-1 flex items-center justify-evenly space-x-1">
                                        <div class="w-[25px] flex justify-center items-center h-full ">
                                            -
                                        </div>
                                        <div class="w-[15px] flex justify-end items-center h-full ">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-2.5 h-2.5"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"/></svg>
                                        </div>
                                    </div>
                                    <div class="bg-note-gray-1 w-[26px] h-[26px] rounded-md flex justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4"><path fill="#BDBDBD" d="M312 320h136V56c0-13.3-10.7-24-24-24H24C10.7 32 0 42.7 0 56v400c0 13.3 10.7 24 24 24h264V344c0-13.2 10.8-24 24-24zm129 55l-98 98c-4.5 4.5-10.6 7-17 7h-6V352h128v6.1c0 6.3-2.5 12.4-7 16.9z"/></svg>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        
                    </tbody>
                </table>
            </div>
            
        </div>

        <!-- <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div> -->
    </AuthenticatedLayout>
</template>
