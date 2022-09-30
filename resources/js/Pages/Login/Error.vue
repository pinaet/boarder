<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { onMounted } from 'vue'

const props = defineProps({
    title: String,
    message: String,
    url: String,
    type: String,
});

const mine = {
    title: props.title,
    message: props.message,
    type: props.type,
    class: '',
}

switch( mine.type )
{
    case 'info': 
        mine.class = " border-blue-200 bg-blue-100 "        
        break;
    case 'danger': 
        mine.class = " border-red-200 bg-red-100 "        
        break;
    case 'success': 
        mine.class = " border-green-200 bg-green-100 "        
        break;
    case 'warning': 
        mine.class = " border-orange-200 bg-orange-100 "        
        break;
    default:
        mine.class = " border-gray-200 bg-gray-100 "
        break;
}

console.log( props.title )
console.log( props.message )
console.log( props.url )

const redirect = function(){
    console.log( 'mine' + mine.title )
    clearInterval( myInterval );
    Inertia.get( props.url )
}

const myInterval = setInterval(redirect, 5000)

onMounted(() => {
    // this.props.message = 'maybe wrong'
    // console.log( this.props.message )
})

</script>

<template>
    <GuestLayout>
        <Head :title="mine.title" />

        <div
            class="
                font-['Arial']
                left-[calc(50%_-_493px_+_-10px)]
                flex
                mt-0
                sm:mt-6
                mb-4
                items-start
                rounded-[10px]
                bg-gray-300
                drop-shadow-lg
            "
        >
            <div
                class="
                    flex flex-col
                    items-center
                    gap-[20px]
                    rounded-tr-[10px]
                    rounded-br-[10px]
                    rounded-tl-[10px]
                    rounded-bl-[10px]
                    bg-white
                    px-12
                    sm:px-20
                    pt-[40px]
                    pb-[40px]
                "
            >
                <div
                    class="
                        flex
                        w-[293px]
                        flex-col
                        items-center
                        gap-[45px]
                        text-center text-2xl text-[rgba(51,51,51,1)]
                    "
                >
                    <div
                        class="
                            h-40
                            w-40
                            [background:url('images/HIS_Bangkok_VERTICAL_ENG_BLUE_square.png')_center_/_cover]
                        "
                    />
                    <p class="font-bold">Boarder Attendance</p>
                    <p :class="'w-full border rounded text-lg p-3 px-5' + mine.class">{{ message }}</p>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
