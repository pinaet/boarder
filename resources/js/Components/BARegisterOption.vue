<script setup>
    import { ref } from 'vue'

    const props = defineProps(['attendances'])

    const emit = defineEmits([
        'toggle'
    ])

    function update(value){
        // alert(value)
        emit('toggle',value)
    }
</script>


<template >    
    <!-- Attendance Dropdown -->
    <div class="absolute top-[26px] left-[0px] w-[195px] -pl-1 shadow-md">
        <button v-for="attendance in attendances" :key="attendance.id" @click="update(attendance.attendance_type_name)" class="border-stroke-gray-1 text-info-gray-2 hover:text-white h-fit w-full flex pl-2  border-b" :style="'background-color: '+attendance.display_colour">
            <div class="w-[20px] h-[26px] text-xs flex justify-center items-center">{{attendance.display_symbol}}</div>
            <div class="w-[24px] h-[26px] text-xs flex justify-center items-center">-</div>
            <div class="w-full min-h-[26px] text-xs text-left flex justify-start items-center">{{attendance.attendance_type_name}}</div>
        </button>
    </div>
</template>
