<script setup>
    import { toRefs, ref, watch } from 'vue'

    const props = defineProps({
        isOn: Boolean,
        label: String,
    })

    const emit = defineEmits([
        'toggle'
    ])

    function update(value){
        emit('toggle',!value)
    }
</script>


<template>
    <div class="flex justify-center items-center h-full">
        <div class="mr-2">
            <button @click="update(isOn)" class="px-[2px] flex items-center w-9 h-5 shadow-inner rounded-full " :class="isOn==true ? 'bg-harrow-gold-100 justify-end' : 'bg-gray-300 justify-start'">
                <button class="w-4 h-4 shadow-md rounded-full bg-white">
                </button>
            </button>
        </div>
        <div class="text-gray-400 text-sm">{{label}}</div>
    </div>    
</template>
