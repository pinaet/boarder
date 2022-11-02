<script setup>
    import { ref, computed }     from 'vue'
    import { useForm, Head }     from '@inertiajs/inertia-vue3';

    import AuthenticatedLayout   from '@/Layouts/AuthenticatedLayout.vue';
    import BAInputInfo           from '@/Components/BAInputInfo.vue';
    import BALabelInfo           from '@/Components/BALabelInfo.vue';
    import InputError            from '@/Components/InputError.vue';
     
    const props                  = defineProps([
                                        'setting_permits',
                                        'errors'
                                   ]) 
    
    const form                   = useForm({
        username: '',
    });
    

    //functions
    function login_as( event )
    {
        form.post(route('login.as.change'), {
            onSuccess: () => {
                form.reset() 
            }
        })
    }

</script>

<template>
    <Head title="Login As" />

    <AuthenticatedLayout :setting_permits="setting_permits">
        
        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl min-h-[50px] h-fit mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-start sm:items-center items-start space-x-6 space-y-2 sm:space-y-0 sm:py-0 sm:pb-0 py-1">
                <div class="w-full sm:w-fit flex justify-between items-center">
                    <div class="flex justify-between items-center space-x-6">
                        <h4 class="font-semibold text-xl text-gray-800 ">
                            Login As
                        </h4>
                    </div>
                </div>
            </div>
        </header>

        <!-- Notes Container -->       
        <form @submit.prevent="login_as(true)">  
            <div class="h-fit w-full z-[1051] flex justify-center mt-9 sm:mt-20">
                <div class="w-[511px] h-fit bg-white rounded-lg overflow-clip shadow-md">
                    <div class="bg-harrow-blue-100 h-[33px]">
                        <div class="text-white flex justify-center items-center h-full">
                            <div class="pl-2 font-bold">Login As</div>
                        </div>
                    </div>
                    <div class="py-[14px] px-1 sm:px-[17px]">
                        <div class="flex justify-evenly">               
                                <div class="w-full h-fit pr-2">
                                    <BAInputInfo :value="form.username" @trigger="form.username=$event">Username:</BAInputInfo>
                                    <InputError v-if="form.errors.username" :message="form.errors.username" class="mt-2" />
                                    <InputError v-if="errors.message" :message="errors.message" class="mt-2" />
                                    <!-- <div v-if="$page.props.errors.username">{{ $page.props.errors.username }}</div> -->
                                </div>
                                <button type="submit" class="w-[111px] h-[37px] rounded-md font-bold text-base text-white ml-2 mr-[1px] border border-[#c3c8d2] bg-harrow-gold-100 flex justify-evenly items-center mt-2.5">
                                    <!-- login-alt -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4" viewBox="0 0 512 512">
                                    <path fill="#fff" d="M416 448h-84c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h84c17.7 0 32-14.3 32-32V160c0-17.7-14.3-32-32-32h-84c-6.6 0-12-5.4-12-12V76c0-6.6 5.4-12 12-12h84c53 0 96 43 96 96v192c0 53-43 96-96 96zm-47-201L201 79c-15-15-41-4.5-41 17v96H24c-13.3 0-24 10.7-24 24v96c0 13.3 10.7 24 24 24h136v96c0 21.5 26 32 41 17l168-168c9.3-9.4 9.3-24.6 0-34z"/></svg>
                                    Login
                                </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>    

    </AuthenticatedLayout>
</template>
