<script setup>
    import { ref } from 'vue'

    const showList = ref(false)

    const props = defineProps([
        'value',
        'data',
        'data_name'
    ])

    const data_name = ! props.data_name ? 'building_name' : props.data_name

    const emit = defineEmits([
        'trigger'
    ])

    function update(value){
        emit('trigger',value)
    }
</script>


<template>    
    <div class="flex-col relative">
        <div class="text-[12px] px-[2px] ml-2 absolute bg-white -top-2.5">
            <slot/>
        </div>
        <button class="w-full text-[14px] text-info-gray-3 border-stroke-gray-3 border h-[37px] font-bold rounded-md mt-2 flex justify-between items-center" @click="showList=!showList" :class="showList ? 'rounded-b-none' : ''">
            <div class="p-2 pl-3">{{value}}</div>
            
            <div class="mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2" viewBox="0 0 512 512"><path fill="#828282" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
            </div>
            <div v-show="showList" class="absolute top-[37px] w-full -ml-[1px] shadow-md border border-t-0 border-stroke-gray-3 rounded-b-md overflow-clip bg-white">
                <div v-for="(dat, i) in data" :key="dat.id" @click="update( dat[ data_name ] )" 
                    class="border-stroke-gray-3 hover:bg-fill-gray-2 h-[29px] flex pl-3 items-center" 
                    :class=" i==data.length-1 ? '' : 'border-b' ">
                    {{dat[ data_name ]}}
                </div>
            </div>
            
        </button>
    </div>
</template>
