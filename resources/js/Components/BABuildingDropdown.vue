<script setup>

    import { ref } from 'vue'

    const showList = ref(false)

    const props = defineProps(['data'])

    const emit = defineEmits([
        'toggle'
    ])

    function update(value){
        emit('toggle',value)
    }
</script>


<template>
    <button class="border-stroke-gray-3 border ml-1 pl-1 w-48 h-[38px] rounded-md flex justify-evenly items-center relative" @click="showList=!showList">
        <p class="w-3/4 flex justify-start ">
            <slot/>
        </p>
        <div class="flex justify-end">
            <div class="w-2 h-2 text-right">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#828282" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
            </div>
        </div>
        <div v-show="showList" class="absolute top-[37px] -left-[1px] z-[1030] w-48 shadow-md border border-t-0 border-stroke-gray-3 rounded-b-md overflow-clip bg-fill-gray-2">
            <div v-for="(dat, i) in data" :key="dat.id" @click="update( dat )" 
                class="border-stroke-gray-3 hover:bg-fill-gray-3 h-[38px] flex pl-3 items-center" 
                :class=" i==data.length-1 ? '' : 'border-b' ">
                {{dat}}
            </div>
        </div>
    </button> 
</template>
