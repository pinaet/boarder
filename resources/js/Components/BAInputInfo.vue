<script setup>
    defineProps(['value'])

    const emit = defineEmits([
        'trigger'
    ])

    function update(value){
        alert(value)
        emit('trigger',value)
    }
</script>


<template>    
    <div class="flex-col relative">
        <div class="text-[12px] px-[2px] ml-2 absolute bg-white">
            <slot/>
        </div>
        <input type="text" class="w-full text-[14px] h-[37px] text-info-gray-3 border-stroke-gray-3 font-bold rounded-md mt-2.5" :value="value" @change="update(value)" />
    </div>
</template>
