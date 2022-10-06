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
            <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8 flex space-x-6 ">
                <h4 class="font-semibold text-xl text-gray-800 leading-loose">
                    Registration
                </h4>
                <div class="flex align-middle">
                    <div class="text-gray-400 text-sm leading-loose pt-[7px] mr-1">Building:</div>
                    <button class="border-gray-600 border ml-1 pt-1 pl-1 w-36 rounded-md flex justify-center">
                            <p class=" pt-1 pr-5">West Acre</p>
                        <div class="pl-4 pt-3 ">
                            <div class="w-2 h-2 text-right">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#828282" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                            </div>
                        </div>
                    </button>                    
                </div>
                <div class="flex align-middle">
                    <div class="text-gray-400 text-sm leading-loose pt-[8px]">Week:</div>
                    <div class="flex">
                        <div class="p-0 mt-[12px] mx-2 ">
                            <button class="w-5 h-5 shadow-md rounded-full border-2 bg-white hover:bg-harrow-gold-20">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#828282" d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256S114.6 512 256 512s256-114.6 256-256zM116.7 244.7l112-112c4.6-4.6 11.5-5.9 17.4-3.5s9.9 8.3 9.9 14.8l0 64 96 0c17.7 0 32 14.3 32 32l0 32c0 17.7-14.3 32-32 32l-96 0 0 64c0 6.5-3.9 12.3-9.9 14.8s-12.9 1.1-17.4-3.5l-112-112c-6.2-6.2-6.2-16.4 0-22.6z"/></svg>
                            </button>
                        </div>
                        <p class="leading-loose w-auto text-base font-bold text-center mt-[6px] text-harrow-gold-100">12 September 2022 - 18 September 2022</p>
                        <div class="p-0 mt-[12px] mx-2 ">
                            <button class="w-5 h-5 shadow-md rounded-full border-2 bg-white hover:bg-harrow-gold-20">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#828282" d="M0 256C0 397.4 114.6 512 256 512s256-114.6 256-256S397.4 0 256 0S0 114.6 0 256zm395.3 11.3l-112 112c-4.6 4.6-11.5 5.9-17.4 3.5s-9.9-8.3-9.9-14.8l0-64-96 0c-17.7 0-32-14.3-32-32l0-32c0-17.7 14.3-32 32-32l96 0 0-64c0-6.5 3.9-12.3 9.9-14.8s12.9-1.1 17.4 3.5l112 112c6.2 6.2 6.2 16.4 0 22.6z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <BaSwitch v-bind:state="on_weekly" label="Weekly" @updateVal="on_weekly=$event" />
                <BaSwitch v-bind:state="on_mis_data" :label="'Show Attendance From ' + $page.props.app.mis" @updateVal="on_mis_data=$event"  />
            </div>
        </header>

        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden ">
                    <div class="p-1 text-[#828282] text- font-bold text-center">
                        2022-23 Term 1 ( Week 5 ) {{on_mis_data}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Boarder Columns -->
        <div class="max-w-7xl mx-auto sm:pl-6 sm:pr-6 lg:pl-8 ">
            <div class="w-full min-h-[73vh] overflow-auto">
                <table class="w-[1484px] table-fixed border-collapse">
                    <thead >
                        <tr class="w-[1484px] h-[31px] text-sm text-info-gray-1 shadow-sm">
                            <th colspan="3" class="font-normal w-[424px] bg-fill-gray-1 border border-stroke-gray-1 text-center">
                                7 Boarders
                            </th>
                            <th colspan="12" class="font-normal w-[528px] bg-fill-gray-3 border border-stroke-gray-2 text-center">
                                Monday ( 3 Oct 2022 )
                            </th>
                            <th colspan="12" class="font-normal w-[528px] bg-fill-gray-2 border border-stroke-gray-2 text-center">
                                Tuesday ( 4 Oct 2022 )
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="w-[1484px] bg-fill-gray-1 flex shadow-sm " :class=" on_mis_data? 'h-[31px]': 'h-[66px]'">
                            <td class="w-[232px] pt-1 text-sm text-center text-info-gray-2 border-b border-l">  
                                <div class="inline-block">
                                    <div class="pt-[1px] pl-1 flex ">
                                        <div class="w-3.5 h-3.5 pt-1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#4F4F4F" d="M256 288c79.5 0 144-64.5 144-144S335.5 0 256 0S112 64.5 112 144s64.5 144 144 144zm-94.7 32C72.2 320 0 392.2 0 481.3c0 17 13.8 30.7 30.7 30.7H481.3c17 0 30.7-13.8 30.7-30.7C512 392.2 439.8 320 350.7 320H161.3z"/></svg></div>
                                        <p class="font-bold ml-1 pt-[2px]">Name</p>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[114px] pt-1 text-sm text-center text-info-gray-2 border-b ">
                                <div class="inline-block">
                                    <div class="pt-[1px] pl-1 flex ">
                                        <div class="w-3.5 h-3.5 pt-1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#4F4F4F" d="M543.8 287.6c17 0 32-14 32-32.1c1-9-3-17-11-24L512 185V64c0-17.7-14.3-32-32-32H448c-17.7 0-32 14.3-32 32v36.7L309.5 7c-6-5-14-7-21-7s-15 1-22 8L10 231.5c-7 7-10 15-10 24c0 18 14 32.1 32 32.1h32v69.7c-.1 .9-.1 1.8-.1 2.8V472c0 22.1 17.9 40 40 40h16c1.2 0 2.4-.1 3.6-.2c1.5 .1 3 .2 4.5 .2H160h24c22.1 0 40-17.9 40-40V448 384c0-17.7 14.3-32 32-32h64c17.7 0 32 14.3 32 32v64 24c0 22.1 17.9 40 40 40h24 32.5c1.4 0 2.8 0 4.2-.1c1.1 .1 2.2 .1 3.3 .1h16c22.1 0 40-17.9 40-40V455.8c.3-2.6 .5-5.3 .5-8.1l-.7-160.2h32z"/></svg></div>
                                        <p class="font-bold ml-1 pt-[2px]">Building</p>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[78px] pt-1 text-sm text-center text-info-gray-2 border-b border-r">
                                <div class="inline-block">
                                    <div class="pt-[1px] pl-1 flex ">
                                        <div class="w-4 h-4 pt-[5px]"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="#4F4F4F" d="M184 48H328c4.4 0 8 3.6 8 8V96H176V56c0-4.4 3.6-8 8-8zm-56 8V96H64C28.7 96 0 124.7 0 160v96H192 352h8.2c32.3-39.1 81.1-64 135.8-64c5.4 0 10.7 .2 16 .7V160c0-35.3-28.7-64-64-64H384V56c0-30.9-25.1-56-56-56H184c-30.9 0-56 25.1-56 56zM320 352H224c-17.7 0-32-14.3-32-32V288H0V416c0 35.3 28.7 64 64 64H360.2C335.1 449.6 320 410.5 320 368c0-5.4 .2-10.7 .7-16l-.7 0zm320 16c0-79.5-64.5-144-144-144s-144 64.5-144 144s64.5 144 144 144s144-64.5 144-144zM496 288c8.8 0 16 7.2 16 16v48h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H496c-8.8 0-16-7.2-16-16V304c0-8.8 7.2-16 16-16z"/></svg></div>
                                        <p class="font-bold ml-1 pt-[2px]">Type</p>
                                    </div>
                                </div>
                            </td>


                            <td class="w-[82px] text-xs text-center underline px-1 -mt-[3px] border">
                                Morning 0715
                            </td>
                            <td class="w-[82px] text-xs text-center underline px-1 -mt-[3px] border">
                                Callover 1740
                            </td>
                            <td class="w-[25px] text-xs text-center underline px-1 -mt-[3px] border"><span class="inline-block -rotate-90">Morning</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -mt-[3px] border"><span class="inline-block -rotate-90">Afternoon</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -mt-[3px] border"><span class="inline-block -rotate-90">Reg</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -mt-[3px] border"><span class="inline-block -rotate-90">Lession1</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -mt-[3px] border"><span class="inline-block -rotate-90">Lession2</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -mt-[3px] border"><span class="inline-block -rotate-90">Lession3</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -mt-[3px] border"><span class="inline-block -rotate-90">Lession4</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -mt-[3px] border"><span class="inline-block -rotate-90">Lession5</span></td>
                            <td class="w-[82px] text-xs text-center underline px-1 -mt-[3px] border">Bed</td>
                            <td class="w-[82px] text-xs text-center underline px-1 -mt-[3px] border">Offsite Status</td>


                            <td class="w-[82px] text-xs text-center underline px-1 -mt-[3px] border">
                                Morning 0715
                            </td>
                            <td class="w-[82px] text-xs text-center underline px-1 -mt-[3px] border">
                                Callover 1740
                            </td>
                            <td class="w-[25px] text-xs text-center underline px-1 -mt-[3px] border"><span class="inline-block -rotate-90">Morning</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -mt-[3px] border"><span class="inline-block -rotate-90">Afternoon</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -mt-[3px] border"><span class="inline-block -rotate-90">Reg</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -mt-[3px] border"><span class="inline-block -rotate-90">Lession1</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -mt-[3px] border"><span class="inline-block -rotate-90">Lession2</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -mt-[3px] border"><span class="inline-block -rotate-90">Lession3</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -mt-[3px] border"><span class="inline-block -rotate-90">Lession4</span></td>
                            <td class="w-[25px] text-xs text-center underline px-1 -mt-[3px] border"><span class="inline-block -rotate-90">Lession5</span></td>
                            <td class="w-[82px] text-xs text-center underline px-1 -mt-[3px] border">Bed</td>
                            <td class="w-[82px] text-xs text-center underline px-1 -mt-[3px] border">Offsite Status</td>

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
