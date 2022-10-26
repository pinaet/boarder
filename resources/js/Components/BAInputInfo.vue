<script setup>    
    import { ref } from 'vue'

    const props = defineProps(['value'])
    const value = ref()
    value.value = props.value

    const emit = defineEmits([
        'trigger'
    ])

    function update(){
        console.log( value.value )
        emit('trigger', value.value )
    }
</script>


<template>    
    <div class="flex-col relative">
        <div class="text-[12px] px-[2px] ml-2 absolute bg-white">
            <slot/>
        </div>
        <input type="text" class="w-full text-[14px] h-[37px] text-info-gray-3 border-stroke-gray-3 font-bold rounded-md mt-2.5" v-model="value" @change="update()" />
    </div>
</template>
