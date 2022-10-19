<script setup>
    import { ref } from 'vue'
    import BARegisterOption from '@/Components/BARegisterOption.vue';

    defineProps(['attendances','on_mis_data'])
    defineEmits(['batch'])

    let on_reg = ref(false)

    function update()
    {
        // on_reg=!on_reg
        alert('update')
    }
</script>


<template>
    <td class="w-[82px] text-xs flex justify-center items-center text-center underline px-2 border-l border-b bg-fill-gray-1">
        <button @click="on_reg=!on_reg">
            <slot />
            <BARegisterOption v-show="on_reg" :attendances="attendances" :style="on_mis_data? 'top: 66px': 'top: 31px'" ></BARegisterOption>
        </button>
    </td>
</template>
