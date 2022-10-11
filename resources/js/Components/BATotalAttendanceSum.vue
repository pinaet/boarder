<script setup>
    defineProps(['attendance'])
</script>


<template>       
    <td class="w-[82px] h-full border-l border-b border-r text-sm border-stroke-gray-1 flex justify-center items-center" :style="'background-color: '+ attendance.display_colour">
        <slot/>
    </td>
</template>
