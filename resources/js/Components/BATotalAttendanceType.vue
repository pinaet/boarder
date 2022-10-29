<script setup>
    defineProps(['attendance'])
</script>


<template>       
    <!-- bg-[#74B9FF] -->
    <td colspan="3" class="h-full border-l border-b border-r border-stroke-gray-1 flex justify-start items-center pl-4" :style="'background-color: '+ attendance.display_colour">
        <div class="pl-1 w-[20px] text-info-gray-2 text-[14px] flex justify-center items-center">{{attendance.display_symbol}}</div>
        <div class="pl-1 w-[24px] text-info-gray-2 text-[14px] flex justify-center items-center">-</div>
        <div class="pl-1 w-full text-info-gray-2 text-[14px] flex items-center truncate">{{attendance.attendance_type_name}}</div>
    </td>
</template>
