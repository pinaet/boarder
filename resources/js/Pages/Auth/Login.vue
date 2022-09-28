<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputBA from '@/Components/InputBA.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia'

defineProps({
    canResetPassword: Boolean,
    status: String,
});

// const form = useForm({
//     email: '',
//     password: '',
//     remember: false
// });
const form = useForm({
    email: 'test',
    password: '',
    processing: false,
});

const submit = () => {        
    Inertia.post( usePage().props.value.appUrl+'/login', {
        email: form.email,
        password: form.password,
    })
    // form.post(route('login'), {
    //     onFinish: () => form.reset('password'),
    // });
};



</script>

<template>

    <GuestLayout>
        
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        
        <div class=" font-['Arial'] left-[calc(50%_-_493px_+_-10px)] flex mt-0 sm:mt-4 mb-4 items-start rounded-[10px] bg-gray-300 drop-shadow-lg">
            <div class="h-[550px] w-[500px] rounded-tl-[10px] rounded-bl-[10px] hidden sm:block [background:url('images/bh-gathering.jpg')_no-repeat_right/_cover]" />
            <div class="flex flex-col items-center gap-[20px] rounded-tr-[10px] rounded-br-[10px] rounded-tl-[10px] rounded-bl-[10px] sm:rounded-tl-none sm:rounded-bl-none bg-white px-12 sm:px-20 pt-[40px] pb-[40px]">
                <div class="flex w-[293px] flex-col items-center gap-[45px] text-center text-2xl text-[rgba(51,51,51,1)]">
                    <div class="h-40 w-40 [background:url('images/HIS_Bangkok_VERTICAL_ENG_BLUE_square.png')_center_/_cover]" />
                    <p class="font-bold">Boarder Attendance {{form.email}}</p>
                </div>
                <form @submit.prevent="submit">
                    
                    <div class="flex w-[326px] flex-col items-start gap-[15px]">
                        <InputBA id="email" :value="form.email"  label="Email" type="text" autocomplete @changeUsername="form.email=$event" />
                        <InputBA id="password" :value="form.password" label="Password" type="password" form="true" @changeUsername="form.password=$event" />
                    </div>
                    <button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="hover:opacity-95 mt-7 flex items-start gap-2.5 rounded-[5px] font-bold border border-solid border-[rgba(154,137,94,1)] bg-[rgba(163,145,99,1)] pl-[141px] pr-[141px] pt-[15px] pb-[15px] text-left text-base text-white">
                        <p >Login</p>
                    </button>

                </form>
            </div>
        </div>
    </GuestLayout>
    
    <!-- <GuestLayout>


        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Forgot your password?
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout> -->
</template>
