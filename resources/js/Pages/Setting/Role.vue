<script setup>
    import { ref, computed }     from 'vue'
    import { Head, Link }        from '@inertiajs/inertia-vue3';

    import AuthenticatedLayout   from '@/Layouts/AuthenticatedLayout.vue';
    import BABlackdrop           from '@/Components/BABlackdrop.vue';
    import BALoading             from '@/Components/BALoading.vue';
    import BAInputInfo           from '@/Components/BAInputInfo.vue';
    import BALabelInfo           from '@/Components/BALabelInfo.vue';
    import BASelect              from '@/Components/BASelect.vue';
    import BASwitch              from '@/Components/BASwitch.vue';
     
    const props                  = defineProps([
                                        'setting_permits',
                                        'roles',
                                        'contents',
                                   ]) 

    const c_admin                = ref()
    const c_admin_bak            = ref()
    const on_role                = ref(false)
    const on_role_mode           = ref()
    const on_loading             = ref(false)
                    
    const roles                  = ref()
    roles.value                  = props.roles
    console.log(roles.value)



    //functions
    const show_admin_modal = function( event ){
        if( ! event ){
            //create new admin
            let new_admin = { 
                'email'     : '',
                'name'      : '',
                'photo'     : '',
                'role_name' : '',
                'telephone' : '',
                'username'  : '',
                'is_blocked': false
            }
            c_admin.value       = new_admin
            on_role_mode.value  = 'create'
        }
        else{
            //edit existing admin
            c_admin.value       = event
            c_admin_bak.value   = JSON.parse(JSON.stringify(event))
            on_role_mode.value  = 'update'
        }
        // console.log( c_admin.value, on_role_mode.value )

        on_admin.value = ! on_admin.value
    }

    const import_data = function() 
    {
        let input  = document.createElement('input')
        input.type = 'file'
        input.onchange = _ => {
            // you can use this method to get file and perform respective operations
            let files  = Array.from(input.files)
            var blob   = files[0]

            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function (){
                var base64String = reader.result;
                // console.log('Base64 String - ', base64String);
            
                // Simply Print the Base64 Encoded String,
                // without additional data: Attributes.
                c_admin.value.photo = base64String.substr(base64String.indexOf(',') + 1)
                console.log( c_admin.value )
            }
        }
        input.click();
    
    }
    
    const cancel_admin = function(){

        //update back
        if( on_role_mode.value=='update' ){
            c_admin.value.email     = c_admin_bak.value.email
            c_admin.value.name      = c_admin_bak.value.name
            c_admin.value.photo     = c_admin_bak.value.photo
            c_admin.value.role_name = c_admin_bak.value.role_name
            c_admin.value.telephone = c_admin_bak.value.telephone
            c_admin.value.username  = c_admin_bak.value.username
        }

        on_admin.value          = false
    }
    
    const save_admin = function(){
        c_admin.value.username = c_admin.value.email.split('@')[0]

        if(c_admin.value.role_name==''){
            alert('Please select role for the user!')
        }
        else{
            let data = { 
                'c_admin'      : c_admin.value,
            }

            axios.post('/setting/staff/save', data )
                .then((res) => {
                    console.log(res.data.message)
                    if( on_role_mode.value=='create' ){
                        admins.value.push( res.data.admin )
                    }
                })
                .catch((error) => {
                    console.log( error )
                })

            on_admin.value          = false
        }
    }
    
    const delete_admin = function(event){

        let ans = confirm( 'Please confirm to delete ' + event.name )
        if( ans ){
            let data = { 
                'c_admin'      : event,
            }

            axios.post('/setting/staff/delete', data )
                .then((res) => {
                    console.log(res.data.message)
                    admins.value.forEach((admin,i) => {
                        if( admin.id==res.data.admin.id ){
                            console.log( admin, res.data.admin,  i, admins.value[i] )
                            admins.value.splice( i, 1 )
                            return
                        }
                    })
                })
                .catch((error) => {
                    console.log( error )
                })

        }
    }
    
</script>

<template>
    <Head title="Setting" />

    <AuthenticatedLayout :setting_permits="setting_permits">
        
        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl h-[50px] mx-auto px-4 sm:px-6 lg:px-8 flex justify-start items-center space-x-6">
                <h4 class="font-semibold text-xl text-gray-800 ">
                    <Link :href="route('setting')" class="hover:text-harrow-gold-100">Setting</Link> / Roles
                </h4>
            </div>
        </header>

        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden flex justify-between items-center">
                    <div class="p-1 text-[#828282] text- font-bold text-center">
                        {{roles.length}} Roles
                    </div>
                    <div class="p-1 ">
                        <button @click="show_admin_modal()" class="w-[181px] h-[34px] rounded-md text-base text-white border border-[#c3c8d2] bg-harrow-blue-100 hover:bg-harrow-blue-90 flex justify-evenly items-center" 
                        target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3" viewBox="0 0 448 512"><!-- plus --><path fill="#fff" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/></svg>
                            Add New Role
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panels -->
        
        <!-- Boarder Columns -->
        <div class="flex flex-col h-[78vh] max-w-7xl mx-auto sm:pl-6 sm:pr-6 lg:pl-8 ">
            <div class="w-full flex-grow overflow-auto rounded">
                <table class="relative table-fixed border-collapse w-fit">
                    <thead class="sticky top-0" :style="'z-index:'+(roles.length+1)">
                        <tr class="h-[27px] sticky top-[31px] flex border-stroke-gray-1 border-b" 
                            :style="['z-index:'+(roles.length+1)]"
                        >
                            <td 
                                class="w-10 h-full sticky text-sm flex justify-center items-center text-info-gray-2 bg-harrow-gold-20 border-l border-b border-r" :style="'z-index:'+(roles.length+2)"
                            >
                                <p class="font-bold pt-1">#</p>
                            </td>
                            <td 
                                class="w-[304px] h-full sticky text-sm flex justify-center items-center text-info-gray-2 bg-harrow-gold-20 border-l border-b" :style="'z-index:'+(roles.length+2)"
                            >
                                <div class="flex w-auto justify-center items-center">
                                    <p class="font-bold ml-1 pt-[2px]">Role</p>
                                </div>
                            </td>
                            <td 
                                class="w-[79px] h-full sticky pt-1 text-sm flex justify-center items-center text-info-gray-2 bg-harrow-gold-20 border-b border-r" :style="'z-index:'+(roles.length+2)"
                            >
                                <div class="flex w-auto justify-center items-center">
                                    <p class="font-bold ml-1 pt-[2px]">Manage</p>
                                </div>
                            </td>

                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data -->
                        <tr v-for="(role, index) in roles" :key="role.pupil_id" class="flex h-[56px] bg-white hover:bg-gray-50">
                            <td class="w-10 text-sm text-center flex justify-center items-center text-info-gray-2 border-b border-r" >
                                {{index+1}}
                            </td>
                            <td class="w-[304px] text-sm text-center flex justify-center items-center text-info-gray-2 border-b" >
                                {{role.role_name}}
                            </td>
                            <td class="w-[79px] text-sm text-center flex justify-center items-center text-info-gray-2 border-b border-r">
                                    <button @click="show_admin_modal(admin)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 ml-1 p-0"><path fill="#a39163" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM325.8 139.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-21.4 21.4-71-71 21.4-21.4c15.6-15.6 40.9-15.6 56.6 0zM119.9 289L225.1 183.8l71 71L190.9 359.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z"/></svg>
                                    </button>
                                    <button @click="delete_admin(admin)" class="ml-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 ml-1 p-0"><!-- trash-alt --><path fill="#a39163" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"/></svg>
                                    </button>
                            </td>

                        </tr>                        
                    </tbody>
                </table>
            </div>            
        </div>
        

        <!-- Admin Modal-->
        <div v-if="on_role">
            <!-- Admin Container -->
            <div class="fixed left-0 top-0 h-full w-full z-[1051] flex justify-center mt-2">
                <div class="left-0 top-0 w-[493px] sm:w-[511px] bg-note-gray-1 rounded-lg shadow-md min-h-[565px] h-[94vh] ">
                    <div class="bg-harrow-blue-100 h-[33px] rounded-t-lg">
                        <div class="text-white flex justify-center items-center h-full">
                            <div>
                                <!-- user-alt -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[15px] h-[15px]" viewBox="0 0 512 512"><path fill="#fff" d="M256 288c79.5 0 144-64.5 144-144S335.5 0 256 0 112 64.5 112 144s64.5 144 144 144zm128 32h-55.1c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16H128C57.3 320 0 377.3 0 448v16c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48v-16c0-70.7-57.3-128-128-128z"/></svg>
                            </div>
                            <div class="pl-2 font-bold capitalize">{{on_role_mode}} Admin</div>
                        </div>
                    </div>
                    <div class="pt-[14px] px-3 sm:px-[23px]">
                        <div class="w-[465px] bg-white border border-harrow-gold-100 rounded-lg text-info-gray-3 h-fit">
                            <div class="w-full h-[288px] flex px-[18px] pt-[22px] border-b border-harrow-gold-100">
                                <div class="overflow-clip pr-[18px] w-[165px] flex flex-col items-center">
                                    <img class="w-[147px] h-[191px] border-[#C3C8D2] bg-slate-50 object-cover object-top rounded-lg border" :src="!c_admin.photo? '/images/anonymous.png' : 'data:image/png;base64,' +  c_admin.photo"/>
                                    <button @click="import_data()" class="w-[81px] h-[29px] rounded-md font-bold text-white text-sm mt-3 border border-[#c3c8d2] bg-harrow-gold-100 flex justify-evenly items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3" viewBox="0 0 384 512"><!-- portrait --><path fill="#fff" d="M336 0H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48zM192 128c35.3 0 64 28.7 64 64s-28.7 64-64 64-64-28.7-64-64 28.7-64 64-64zm112 236.8c0 10.6-10 19.2-22.4 19.2H102.4C90 384 80 375.4 80 364.8v-19.2c0-31.8 30.1-57.6 67.2-57.6h5c12.3 5.1 25.7 8 39.8 8s27.6-2.9 39.8-8h5c37.1 0 67.2 25.8 67.2 57.6v19.2z"/></svg>
                                        <p>Change</p>    
                                    </button>
                                </div>
                                <div class=" pl-[18px] flex-col w-[282px]">
                                    <table class="w-full">
                                        <tr class="w-full">
                                            <td>
                                                <BALabelInfo label="Username">{{ ! c_admin.username ? '-' : c_admin.username }}</BALabelInfo>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pt-5">
                                                <BAInputInfo :value="c_admin.name" @trigger="c_admin.name=$event">Name:</BAInputInfo>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pt-5">
                                                <BAInputInfo :value="c_admin.email" @trigger="c_admin.email=$event">Email:</BAInputInfo>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pt-5">
                                                <BAInputInfo :value="c_admin.telephone" @trigger="c_admin.telephone=$event">Telephone:</BAInputInfo>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="w-full h-[75px] flex px-[18px] pt-3 ">
                                <div class="h-full w-[165px] flex items-start pl-[22px] flex-col">
                                    <BASwitch :isOn="c_admin.is_blocked" label="Blocked" @toggle="c_admin.is_blocked=$event"></BASwitch>
                                </div>
                                <div class="h-full pl-[18px] flex-col w-[282px]">
                                    <BASelect :value="c_admin.role_name" :data="roles" data_name="role_name" @trigger="c_admin.role_name=$event">Role:</BASelect>
                                </div>
                            </div>
                        </div>                        
                        <div class="flex justify-end">
                            <button class="w-[81px] h-[29px] rounded-md font-bold text-white m-3 border border-[#c3c8d2] bg-[#828282]" @click="cancel_admin()">Cancel</button>
                            <button class="w-[81px] h-[29px] rounded-md font-bold text-white mt-3 mb-3 mr-4 border border-[#c3c8d2] bg-harrow-gold-100" @click="save_admin()">Save</button>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading Modal -->
        <BALoading v-if="on_loading">
        </BALoading>

        <!-- Backdrop -->
        <BABlackdrop v-if="on_loading || on_role">
        </BABlackdrop>

    </AuthenticatedLayout>
</template>
