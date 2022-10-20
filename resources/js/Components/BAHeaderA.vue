<script setup>
    import { ref } from 'vue'
    import BARegisterOption from '@/Components/BARegisterOption.vue';

    let props = defineProps(['attendances','on_mis_data', 'header', 'col', 'term'])
    
    const emit = defineEmits([
        'batch'
    ])

    let on_reg = ref(false)
    let header = props.header
    let col    = props.col
    let term   = props.term

    function update( $event )
    {
        // on_reg=!on_reg
        let data = { 
            'academic_year'      : term.academic_year,
            'attendance_id'      : $event,
            'date'               : header.date,
            'notes'              : '',
            'pupil_id'           : '',
            'register_column_id' : col.id,
            'width'              : col.width,
        }
        // console.log( data )

        emit( 'batch', data )
    }
</script>


<template>
    <td class="w-[82px] text-xs flex justify-center items-center text-center underline px-2 border-l border-b bg-fill-gray-1">
        <button @click="on_reg=!on_reg">
            <slot />
            <BARegisterOption v-show="on_reg" :attendances="attendances" :style="on_mis_data? 'top: 66px': 'top: 31px'" @toggle="update($event)"></BARegisterOption>
        </button>
    </td>
</template>
