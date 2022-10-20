<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaSwitch from '@/Components/BASwitch.vue';
import BABuildingDropdown from '@/Components/BABuildingDropdown.vue';
import BATotalAttendanceSum from '@/Components/BATotalAttendanceSum.vue';
import BATotalAttendanceType from '@/Components/BATotalAttendanceType.vue';
import BARegisterOption from '@/Components/BARegisterOption.vue';
import BAInputInfo from '@/Components/BAInputInfo.vue';
import BALabelInfo from '@/Components/BALabelInfo.vue';
import BASelect from '@/Components/BASelect.vue';
import BAHeaderA from '@/Components/BAHeaderA.vue';
import BAHeaderB from '@/Components/BAHeaderB.vue';
import BARegister from '@/Components/BARegister.vue';
import BAAttendMIS from '@/Components/BAAttendMIS.vue';
import BATotalBoarder from '@/Components/BATotalBoarder.vue';
import { useForm, Head } from '@inertiajs/inertia-vue3';

let on_weekly     = ref(false)
let on_mis_data   = ref(false)
let on_reg        = ref(false)
let on_note       = ref(false)
let on_boarder    = ref(false)
let building      = ref('West Acre')
let c_boarder     = ref()
let boarders      = ref()
let totals        = ref()
let term          = ref()
let dates         = ref()
let register      = ref()
let notes         = ref()

let props         = defineProps(['all_boarders','attendances','buildings','dates','term','headers','totals']) 

boarders          = props.all_boarders //JSON.parse(JSON.stringify(props.all_boarders)) -- clone array not working
totals            = props.totals
dates             = props.dates 
term              = props.term

//functions
const assign_boarder = function( boarder ){
    this.on_boarder= !this.on_boarder
    this.c_boarder = boarder
    console.log( this.c_boarder )
}

const update_boarder = function(){
    this.on_boarder = false

    let data = { 
        'boarder' : this.c_boarder 
    }

    axios.post('/boarder/update/profile', data )
        .then((res) => {
            console.log( res.data.message )
        })
        .catch((error) => {
            console.log( error )
        })
}

function change_building( building ){
    
    this.building = building

    let data = { 
        'building' : building 
    }

    axios.post('/boarder/change/building', data )
        .then((res) => {
            console.log( res.data.message )

            // remove all Element in array
            this.boarders.splice( 0, this.boarders.length )

            // update element
            res.data.boarders.forEach( element => {
                this.boarders.push( element )
            });
        })
        .catch((error) => {
            console.log( error )
        })
}

function change_week( direction ){

    let data = { 
        'term'      : this.term,
        'direction' : direction
    }

    axios.post('/boarder/change/week', data )
        .then((res) => {
            console.log( res.data.message )

            // remove all Element in array
            this.dates.splice( 0, this.dates.length )
            // this.term.splice(  0, this.term.length  )
            // this.dates= res.data.dates
            this.term = res.data.term
            // this.term.push( res.data.term )

            // update element
            res.data.dates.forEach( element => {
                this.dates.push( element )
            });
        })
        .catch((error) => {
            console.log( error )
        })
}

function show_note( register, event )
{
    this.register = register
    this.notes    = register.notes
    this.on_note  = event
}

function store_note( event )
{
    if( event==true ){
        let data = { 
            'attendance_id'      : this.register.attendance_id,
            'pupil_id'           : this.register.pupil_id,
            'register_column_id' : this.register.register_column_id,
            'date'               : this.register.date,
            'academic_year'      : this.register.academic_year,
            'notes'              : this.notes,
        }

        this.boarders.forEach( boarder => {
            if(boarder.pupil_id==this.register.pupil_id){
                boarder.registers.forEach( register => {
                    if( register.register_column_id==this.register.register_column_id && register.date==this.register.date ){
                        register.notes = this.notes
                        console.log( boarder )
                        return
                    }
                })
                return
            }
        });
        // console.log( data )

        axios.post('/boarder/store/attendance', data )
            .then((res) => {
                //emit to update total attendance type
            })
            .catch((error) => {
                console.log( error )
            })
    }
    this.register= []
    this.notes   = ''
    this.on_note = false
}

function update_totals( event ){
    let old_reg = event.old_reg
    let new_reg = event.new_reg

    this.totals[old_reg.attendance_id][old_reg.register_column_id][old_reg.width][old_reg.date]--
    this.totals[new_reg.attendance_id][new_reg.register_column_id][new_reg.width][new_reg.date]++
}

function update_totals_col( event ){
    let new_reg = event
    // update register at this column to all boarders
    boarders.forEach( boarder => {
        boarder.registers.forEach( old_reg => {
            if( old_reg.academic_year     == new_reg.academic_year && 
                old_reg.date              == new_reg.date && 
                old_reg.register_column_id== new_reg.register_column_id && 
                old_reg.width             == new_reg.width )
            {
                this.totals[old_reg.attendance_id][old_reg.register_column_id][old_reg.width][old_reg.date]--
                this.totals[new_reg.attendance_id][new_reg.register_column_id][new_reg.width][new_reg.date]++
                old_reg.attendance_id = new_reg.attendance_id
                
                new_reg.pupil_id = boarder.pupil_id
                new_reg.notes    = old_reg.notes

                axios.post('/boarder/store/attendance', new_reg )
                    .then((res) => {
                        // console.log(res.data.message)
                    })
                    .catch((error) => {
                        console.log( error )
                    })
                return
            }
        })
    })
}

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
                    <BABuildingDropdown :data="buildings" @toggle="change_building($event)">{{building}}</BABuildingDropdown>                
                </div>
                <div class="flex justify-start items-center">
                    <div class="text-gray-400 text-sm">Week:</div>
                    <div class="flex justify-evenly items-center">
                        <div class="pt-1 mx-2 ">
                            <button class="w-5 h-5 shadow-md rounded-full border-2 bg-white hover:bg-harrow-gold-20" @click="change_week( 'previous' )">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#828282" d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256S114.6 512 256 512s256-114.6 256-256zM116.7 244.7l112-112c4.6-4.6 11.5-5.9 17.4-3.5s9.9 8.3 9.9 14.8l0 64 96 0c17.7 0 32 14.3 32 32l0 32c0 17.7-14.3 32-32 32l-96 0 0 64c0 6.5-3.9 12.3-9.9 14.8s-12.9 1.1-17.4-3.5l-112-112c-6.2-6.2-6.2-16.4 0-22.6z"/></svg>
                            </button>
                        </div>
                        <p class="w-[320px] text-base text-center font-bold text-harrow-gold-100">{{dates[0].date_long +' - '+ dates[6].date_long}}</p>
                        <div class="pt-1 mx-2 ">
                            <button class="w-5 h-5 shadow-md rounded-full border-2 bg-white hover:bg-harrow-gold-20" @click="change_week( 'next' )">
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
                        {{term.name}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Boarder Columns -->
        <div class="flex flex-col h-[78vh] max-w-7xl mx-auto sm:pl-6 sm:pr-6 lg:pl-8 ">
            <div class="w-full flex-grow overflow-auto rounded" :class="on_mis_data ? '  border-harrow-gold-100' : ''">
                <table class="relative table-fixed border-collapse " :style="[on_mis_data? 'width:'+headers.max_w: 'width:'+headers.min_w]">
                    <thead class="sticky top-0" :style="'z-index:'+(boarders.length+1)">
                        <tr class="h-[31px] text-sm text-info-gray-1 flex" :style="[on_mis_data? 'width:'+headers.max_w: 'width:'+headers.min_w]">
                            <th colspan="3"  class="w-[424px] sticky top-0 left-0 font-normal text-center bg-fill-gray-1 border border-stroke-gray-1 flex justify-center items-center" :style="'z-index:'+(boarders.length+2)">
                                {{boarders.length}} Boarders
                            </th>
                            <th v-for="col in headers.cols" :key="col.id" :colspan="col.colspan" class="sticky top-0 font-normal text-center border border-stroke-gray-2 flex justify-center items-center" :style="[on_mis_data? 'width: '+col.max_w+'px': 'width: '+col.min_w+'px', col.status=='current' ? 'background-color: '+col.color : col.id%2==0?'background-color: #F2F2F2':'background-color: #E0E0E0']">
                                {{col.col_name}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class=" sticky top-[31px] flex border-stroke-gray-1 " :style="['z-index:'+(boarders.length+1), on_mis_data? 'height:66px; width:'+headers.max_w: 'height:31px; width:'+headers.min_w]">
                            <td class="w-[232px] h-full sticky left-0 text-sm flex justify-center items-center text-info-gray-2 bg-fill-gray-1 border-l border-b" :style="'z-index:'+(boarders.length+2)">
                                <div class="flex w-auto justify-center items-center">
                                    <!-- user-alt -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-[15px] h-[15px]"><path fill="#4F4F4F" d="M256 288c79.5 0 144-64.5 144-144S335.5 0 256 0S112 64.5 112 144s64.5 144 144 144zm-94.7 32C72.2 320 0 392.2 0 481.3c0 17 13.8 30.7 30.7 30.7H481.3c17 0 30.7-13.8 30.7-30.7C512 392.2 439.8 320 350.7 320H161.3z"/></svg>
                                    <p class="font-bold ml-1 pt-[2px]">Name</p>
                                </div>
                            </td>
                            <td class="w-[114px] h-full sticky left-[232px] text-sm flex justify-center items-center text-info-gray-2 bg-fill-gray-1 border-b" :style="'z-index:'+(boarders.length+2)">
                                <div class="flex w-auto justify-center items-center">
                                    <!-- home -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-[18px] h-[18px]"><path fill="#4F4F4F" d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z"/></svg>
                                    <p class="font-bold ml-1 pt-[2px]">Building</p>
                                </div>
                            </td>
                            <td class="w-[78px] h-full sticky left-[346px] pt-1 text-sm flex justify-center items-center text-info-gray-2 bg-fill-gray-1 border-b border-r" :style="'z-index:'+(boarders.length+2)">
                                <div class="flex w-auto justify-center items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="w-[18px] h-[18px]"><path fill="#4F4F4F" d="M184 48H328c4.4 0 8 3.6 8 8V96H176V56c0-4.4 3.6-8 8-8zm-56 8V96H64C28.7 96 0 124.7 0 160v96H192 352h8.2c32.3-39.1 81.1-64 135.8-64c5.4 0 10.7 .2 16 .7V160c0-35.3-28.7-64-64-64H384V56c0-30.9-25.1-56-56-56H184c-30.9 0-56 25.1-56 56zM320 352H224c-17.7 0-32-14.3-32-32V288H0V416c0 35.3 28.7 64 64 64H360.2C335.1 449.6 320 410.5 320 368c0-5.4 .2-10.7 .7-16l-.7 0zm320 16c0-79.5-64.5-144-144-144s-144 64.5-144 144s64.5 144 144 144s144-64.5 144-144zM496 288c8.8 0 16 7.2 16 16v48h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H496c-8.8 0-16-7.2-16-16V304c0-8.8 7.2-16 16-16z"/></svg>
                                    <p class="font-bold ml-1 pt-[2px]">Type</p>
                                </div>
                            </td>
                            <template v-for="(header,i) in headers.cols" :key="header.id" >
                                <template v-for="col in headers.cols[i].cols" :key="col.id" >
                                    <BAHeaderA v-if="col.width==82" class="relative" @click="on_reg=!on_reg" :attendances="attendances" :on_mis_data="on_mis_data" :header="header" :col="col" :term="term" @batch="update_totals_col($event)">
                                        {{col.column_name}}
                                    </BAHeaderA>
                                    <BAHeaderB v-else :class="on_mis_data ? '' : 'hidden' ">{{col.column_name}}</BAHeaderB>
                                </template>
                            </template>

                        </tr>


                        <!-- Data -->
                        <tr v-for="(boarder, index) in boarders" :key="boarder.pupil_id" class="sticky flex h-[66px]" :style="['z-index:'+(boarders.length-index),on_mis_data? 'width:'+headers.max_w: 'width:'+headers.min_w]">
                            <td class="w-[232px] sticky left-0 z-20 pt-1 text-sm text-info-gray-2 border-l border-b bg-white">  
                                <div class="p-2.5 pr-0 flex justify-center items-center">
                                    <img class="object-cover object-top w-10 h-10 bg-slate-300 rounded-full mr-2.5 " :src="'data:image/png;base64,' +  boarder.photo" />
                                    <div class="text-left flex-col w-[145px]">
                                        <div class="font-bold truncate">{{boarder.prefered_forename+' '+boarder.surname}}</div>
                                        <div class="text-info-gray-1">{{boarder.year_group}}, {{boarder.form}}, {{boarder.gender=='M'?'Male':'Female'}}</div>
                                    </div>
                                    <button @click="assign_boarder(boarder)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 ml-1 p-0"><path fill="#a39163" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM325.8 139.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-21.4 21.4-71-71 21.4-21.4c15.6-15.6 40.9-15.6 56.6 0zM119.9 289L225.1 183.8l71 71L190.9 359.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z"/></svg>
                                    </button>
                                </div>
                            </td>
                            <td class="w-[114px] sticky left-[232px] z-20 pt-1 text-sm text-center flex justify-center items-center text-info-gray-2 bg-white border-b">
                                {{boarder.building_name}}
                            </td>
                            <td class="w-[78px] sticky left-[346px] z-20 pt-1 text-sm text-center flex justify-center items-center text-info-gray-2 bg-white border-b border-r">
                                {{boarder.boarder_type}}
                            </td>

                            <!-- Registration & Note -->
                            <template v-for="(register,i) in boarder.registers" :key="i" >
                                <!-- pupil_id, date, column_id -->
                                <BARegister v-if="register.width==82" :register="register" :attendances="attendances" @note="show_note( register, $event )" @count="update_totals( $event )"></BARegister>
                                <BAAttendMIS v-else :class="on_mis_data ? '' : 'hidden' ">/</BAAttendMIS>
                            </template>

                        </tr>

                        <!-- Table Footer : Boarder Total -->
                        <tr class="h-[26px] flex" :style="[on_mis_data? 'width:'+headers.max_w: 'width:'+headers.min_w]">
                            <td colspan="3" class="w-[424px] h-full sticky left-0 bg-fill-gray-1 border-l border-b border-r border-stroke-gray-1 flex justify-start items-center pl-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[21px] h-[15px]" viewBox="0 0 640 512"><!-- users --><path fill="#4F4F4F" d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm32 32h-64c-17.6 0-33.5 7.1-45.1 18.6 40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64zm-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zm-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4z"/></svg>
                                <div class="pl-1  font-bold text-info-gray-2 text-[14px] flex items-center">Boarder Total</div>
                            </td>
                            
                            <template v-for="(header,i) in headers.cols" :key="header.id" >
                                <template v-for="col in headers.cols[i].cols" :key="col.id" >
                                    <BATotalBoarder v-if="col.width==82">{{boarders.length}}</BATotalBoarder>
                                    <td v-else class="w-[25px]" :class="[on_mis_data ? '' : 'hidden']"></td>
                                </template>
                            </template>
                        </tr>


                        <!-- Table Footer : Attendance Total -->
                        <tr v-for="attendance in attendances" :key="attendance.id" class="h-[26px] flex" :style="[on_mis_data? 'width:'+headers.max_w: 'width:'+headers.min_w]">
                            <BATotalAttendanceType class="sticky left-0" :attendance="attendance"></BATotalAttendanceType>
                            
                            
                            <template v-for="(header,i) in headers.cols" :key="header.id" >
                                <template v-for="col in headers.cols[i].cols" :key="col.id" >
                                    <BATotalAttendanceSum v-if="col.width==82" :attendance="attendance">
                                        {{ totals[attendance.id][col.id][col.width][header.date]>0 ? totals[attendance.id][col.id][col.width][header.date] : '-' }}
                                    </BATotalAttendanceSum>
                                    <td v-else class="w-[25px]" :class="[on_mis_data ? '' : 'hidden']"></td>
                                </template>
                            </template>
                        </tr>

                        
                    </tbody>
                </table>
            </div>

            <!-- Notes Modal -->
            <div v-show="on_note">
                <!-- Notes Container -->
                <div class="fixed left-0 top-0 h-full w-full z-[51] flex justify-center mt-9 sm:mt-20">
                    <div class="left-0 top-0 w-[511px] h-fit min-h-[193px] bg-note-gray-1 rounded-lg overflow-clip shadow-md">
                        <div class="bg-harrow-blue-100 h-[33px]">
                            <div class="text-white flex justify-center items-center h-full">
                                <div>
                                    <!-- sticky-note -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[16px] h-[16px]" viewBox="0 0 448 512"><path fill="#fff" d="M312 320h136V56c0-13.3-10.7-24-24-24H24C10.7 32 0 42.7 0 56v400c0 13.3 10.7 24 24 24h264V344c0-13.2 10.8-24 24-24zm129 55l-98 98c-4.5 4.5-10.6 7-17 7h-6V352h128v6.1c0 6.3-2.5 12.4-7 16.9z"/></svg>
                                </div>
                                <div class="pl-2 font-bold">Notes</div>
                            </div>
                        </div>
                        <div class="py-[14px] px-1 sm:px-[17px]">
                            <textarea class="w-[478px] h-[100px] bg-white border border-stroke-gray-2 rounded-md text-info-gray-3 p-2" v-model="notes" placeholder="Write some notes..."></textarea>
                            <div class="flex justify-end">
                                <button class="w-[81px] h-[29px] rounded-md font-bold text-white mt-2 border border-[#c3c8d2] bg-[#828282]" @click="store_note(false)">Cancel</button>
                                <button class="w-[81px] h-[29px] rounded-md font-bold text-white mt-2 ml-2 mr-[1px] border border-[#c3c8d2] bg-harrow-gold-100" @click="store_note(true)">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boarder Modal-->
            <div v-if="on_boarder">
                <!-- Boarder Container -->
                <div class="fixed left-0 top-0 h-full w-full z-[51] flex justify-center mt-2">
                    <div class="left-0 top-0 w-[493px] sm:w-[511px] bg-note-gray-1 rounded-lg shadow-md min-h-[565px] h-[94vh] ">
                        <div class="bg-harrow-blue-100 h-[33px] rounded-t-lg">
                            <div class="text-white flex justify-center items-center h-full">
                                <div>
                                    <!-- user-alt -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[15px] h-[15px]" viewBox="0 0 512 512"><path fill="#fff" d="M256 288c79.5 0 144-64.5 144-144S335.5 0 256 0 112 64.5 112 144s64.5 144 144 144zm128 32h-55.1c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16H128C57.3 320 0 377.3 0 448v16c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48v-16c0-70.7-57.3-128-128-128z"/></svg>
                                </div>
                                <div class="pl-2 font-bold">Boarder</div>
                            </div>
                        </div>
                        <div class="pt-[14px] px-3 sm:px-[23px]">
                            <div class="w-[465px] bg-white border border-harrow-gold-100 rounded-lg text-info-gray-3 h-[465px] overflow-y-scroll">
                                <div class="w-full h-[288px] flex px-[18px] pt-[22px] border-b border-harrow-gold-100">
                                    <div class="overflow-clip pr-[18px] w-[165px]">
                                        <img class="w-[147px] h-[191px] border-[#C3C8D2] bg-slate-50 object-cover object-top rounded-lg border" :src="'data:image/png;base64,' +  c_boarder.photo"/>
                                    </div>
                                    <div class=" pl-[18px] flex-col w-[282px]">
                                        <table class="w-full">
                                            <tr class="w-full">
                                                <td colspan="2">
                                                    <BALabelInfo label="Admission No">{{c_boarder.admission_no}}</BALabelInfo>
                                                </td>
                                            </tr>
                                            <tr class=" pt-2.5">
                                                <td class="w-[141px] pt-2.5">
                                                    <BALabelInfo label="Prefered Forename">{{c_boarder.prefered_forename}}</BALabelInfo>
                                                </td>
                                                <td class="w-[141px] pt-2.5 max-w-[120px]">
                                                    <BALabelInfo label="Surname">{{c_boarder.surname}}</BALabelInfo>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pt-2.5">
                                                    <BALabelInfo label="Year Group">{{c_boarder.year_group}}</BALabelInfo>
                                                </td>
                                                <td class="pt-2.5">
                                                    <BALabelInfo label="Form">{{c_boarder.form}}</BALabelInfo>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pt-2.5">
                                                    <BALabelInfo label="Gender">{{c_boarder.gender=='M'?'Male':'Female'}}</BALabelInfo>
                                                </td>
                                                <td class="pt-2.5">
                                                    <BAInputInfo :value="c_boarder.telephone" @trigger="c_boarder.telephone=$event">Telephone:</BAInputInfo>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="pt-2.5">
                                                    <BAInputInfo :value="c_boarder.offsite_permission" @trigger="c_boarder.offsite_permission=$event">Offsite Permission:</BAInputInfo>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="w-full h-[75px] flex px-[18px] pt-3 ">
                                    <div class="h-full w-[165px] flex items-start pl-[22px] flex-col">
                                        <BALabelInfo label="Boarder Type">{{c_boarder.boarder_type}}</BALabelInfo>
                                    </div>
                                    <div class="h-full pl-[18px] flex-col w-[282px]">
                                        <BASelect :value="c_boarder.building_name" :data="buildings" @trigger="c_boarder.building_name=$event">Building:</BASelect>
                                    </div>
                                </div>
                                <div v-for="(contact, i) in c_boarder.contacts" :key="contact.contact_id" class="w-full h-[100px] flex border-t border-harrow-gold-100">
                                    <div class="h-full min-w-[173px] flex flex-col justify-center items-center bg-harrow-blue-100 text-white font-bold" :class="i==c_boarder.contacts.length-1?'rounded-bl-lg' : '' ">
                                        <div>{{contact.relationship}}</div>
                                        <div class="flex justify-center items-center mt-4">
                                            <div class="text-xs font-normal mr-[2px]">Tel.</div>
                                            <div>{{contact.contact_no?contact.contact_no:'(Not available)'}}</div>
                                        </div>
                                    </div>
                                    <div class="h-full flex flex-col justify-evenly pl-4 max-w-[267px] rounded-br-lg">
                                        <BALabelInfo label="Contact Name" >{{contact.contact_name?contact.contact_name:'(Not available)'}}</BALabelInfo>
                                        <BALabelInfo label="Email" class="">{{contact.email?contact.email:'(Not available)'}}</BALabelInfo>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button class="w-[81px] h-[29px] rounded-md font-bold text-white m-3 border border-[#c3c8d2] bg-[#828282]" @click="on_boarder=false">Cancel</button>
                                <button class="w-[81px] h-[29px] rounded-md font-bold text-white mt-3 mb-3 mr-4 border border-[#c3c8d2] bg-harrow-gold-100" @click="update_boarder()">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backdrop -->
            <div v-show="on_note || on_boarder" class="fixed left-0 top-0 h-full w-full z-50 bg-black opacity-70">
            </div>
            
        </div>
    </AuthenticatedLayout>
</template>
