<script setup>
    import { ref } from 'vue'
    import BARegisterOption from '@/Components/BARegisterOption.vue';

    const props = defineProps(['attendances','on_mis_data', 'header', 'col', 'term'])
    
    const emit  = defineEmits([
        'batch'
    ])

    const on_reg = ref(false)
    const header = props.header
    const col    = props.col
    const term   = props.term

    function update( $event )
    {
        // on_reg=!on_reg
        let data = { 
            'academic_year'      : props.term.academic_year,
            'attendance_id'      : $event,
            'date'               : props.header.date,
            'notes'              : '',
            'pupil_id'           : '',
            'register_column_id' : props.col.id,
            'width'              : props.col.width,
        }
        // console.log( data )

        emit( 'batch', data )
    }
</script>


<template>
    <td class="w-[82px] text-xs flex justify-center items-center text-center underline px-2 border-l border-b bg-fill-gray-1">
        <button @click="on_reg=!on_reg">
            <slot />
            <BARegisterOption v-show="on_reg" :attendances="attendances" class="left-[0px]" :style="on_mis_data? 'top: 66px': 'top: 31px'" @toggle="update($event)"></BARegisterOption>
        </button>
    </td>
</template>
