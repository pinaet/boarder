<script setup>
    import { ref } from 'vue'

    const props = defineProps(['on_mis_data', 'header', 'col', 'term', 'on_reg'])
    
    const emit  = defineEmits([
        'toggle'
    ])

    function toggle(){
        let data = { 
            'academic_year'      : props.term.academic_year,
            'attendance_id'      : '',
            'date'               : props.header.date,
            'notes'              : '',
            'pupil_id'           : '',
            'register_column_id' : props.col.id,
            'width'              : props.col.width,
        }
        emit( 'toggle', data )
    }
</script>


<template>
    <td class="w-[82px] text-xs flex justify-center items-center text-center underline px-2 border-l border-b bg-fill-gray-1">
        <button @click="toggle()">
            <slot />
        </button>
    </td>
</template>
