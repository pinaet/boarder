<script setup>
    import { ref, computed, onMounted } from 'vue'

    const props    = defineProps(['attendances','register'])    

    const emit     = defineEmits([
        'note', 'showlist'
    ])

    const register = props.register

    /* computed ช่วยแก้ปัญหา re-render แล้วข้อมูลใน component ไม่ update */
    const attendance_color = computed(()=>{
        let data = ''
        props.attendances.forEach( attenance => {
            if( attenance.id == props.register.attendance_id ){
                data = attenance.display_colour
                return
            }
        })
        return data        
    })
    
    const attendance_symbol = computed(()=>{
        let data = ''
        props.attendances.forEach( attenance => {
            if( attenance.id == props.register.attendance_id ){
                data = attenance.display_symbol
                return
            }
        })
        return data
        
    })    
    
    const notes = computed(()=>{
        return props.register.notes        
    })

    const registered_by = computed(()=>{
        return props.register.registered_by        
    })

    function note(value){
        emit('note',value)
    }

    function show_register(){
        emit('showlist',props.register)
    }
</script>


<template >    
    <td class="w-[82px] bg-white border-l border-b flex flex-col">
        <div class="w-full h-full text-xs pt-1 px-1 flex items-center justify-evenly space-x-1 relative">
            <button @click="show_register()" class="w-[40px] h-[26px] rounded-md px-1 flex items-center justify-evenly space-x-1 " :style="'background-color: '+attendance_color">
                <div class="w-[25px] flex justify-center items-center h-full">
                    {{attendance_symbol}}
                </div>
                <div class="w-[15px] flex justify-end items-center h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-2 h-2"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"/></svg>
                </div>
            </button>
            <button class="bg-note-gray-1 w-[26px] h-[26px] rounded-md flex justify-center items-center" @click="note(true)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4"><path :fill="!notes?'#BDBDBD':'#4F4F4F'" d="M312 320h136V56c0-13.3-10.7-24-24-24H24C10.7 32 0 42.7 0 56v400c0 13.3 10.7 24 24 24h264V344c0-13.2 10.8-24 24-24zm129 55l-98 98c-4.5 4.5-10.6 7-17 7h-6V352h128v6.1c0 6.3-2.5 12.4-7 16.9z"/></svg>
            </button>
        </div>
        <p class="text-xs text-gray-300 pb-1 px-1 text-center w-full truncate">
            {{registered_by}}
        </p>
    </td>
</template>
