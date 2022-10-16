<script setup>
    let props = defineProps(['label'])

    const emit = defineEmits([
        'toggle'
    ])

    function update(value){
        // alert(value)
        emit('toggle',value)
    }
</script>


<template>    
    <div>
        <div class="text-[12px] text-info-gray-2 -mb-1 truncate">{{label}}</div>
        <div class="text-[16px] font-bold truncate">
            <slot/>
        </div>
    </div>
</template>
