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

    const c_role                 = ref()
    const c_role_bak             = ref()
    const on_role                = ref(false)
    const on_role_mode           = ref()
    const on_loading             = ref(false)
                    
    const roles                  = ref()
    const contents               = ref()
    roles.value                  = props.roles
    contents.value               = props.contents

    console.log(roles.value)
    console.log(contents.value)



    //functions
    const show_role_modal = function( event ){
        if( ! event ){
            //create new role
            let new_role = { 
                'id'        : '',
                'role_name' : '',
                'contents'  : [],
            }
            contents.value.forEach( content => {
                let temp = { 
                    'enabled'                 : false,
                    'permission_content_name' : content.permission_content_name,
                    'can_update'              : false,
                }
                new_role.contents.push( temp )
            })

            c_role.value       = new_role
            on_role_mode.value = 'create'
        }
        else{
            //edit existing role
            c_role.value       = event
            c_role_bak.value   = JSON.parse(JSON.stringify(event))
            on_role_mode.value = 'update'
        }
        // console.log( c_role.value, on_role_mode.value )

        on_role.value = ! on_role.value
    }
    
    const cancel_role = function(){

        //update back
        if( on_role_mode.value=='update' ){
            c_role.value.role_name      = c_role_bak.value.role_name

            c_role.value.contents.forEach( (content, i) => {
                content.enabled                 = c_role_bak.value.contents[i].enabled
                content.permission_content_name = c_role_bak.value.contents[i].permission_content_name
                content.can_update              = c_role_bak.value.contents[i].can_update
            })
        }

        on_role.value          = false
    }
    
    const save_role = function(){

        if(c_role.value.role_name==''){
            alert('Please role name must not empty!')
        }
        else{
            let data = { 
                'c_role'      : c_role.value,
            }

            axios.post('/setting/role/save', data )
                .then((res) => {
                    console.log(res.data.message)
                    if( on_role_mode.value=='create' ){
                        roles.value.push( res.data.role )
                    }
                })
                .catch((error) => {
                    console.log( error )
                })

            on_role.value          = false
        }
    }
    
    const delete_role = function(event){

        let ans = confirm( 'Please confirm to delete role: ' + event.role_name )
        if( ans ){
            let data = { 
                'c_role'      : event,
            }

            axios.post('/setting/role/delete', data )
                .then((res) => {
                    console.log(res.data.message)
                    roles.value.forEach((role,i) => {
                        if( role.id==res.data.role.id ){
                            console.log( role, res.data.role,  i, roles.value[i] )
                            roles.value.splice( i, 1 )
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
                        <button @click="show_role_modal()" class="w-[181px] h-[34px] rounded-md text-base text-white border border-[#c3c8d2] bg-harrow-blue-100 hover:bg-harrow-blue-90 flex justify-evenly items-center" 
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
        <div class="flex h-[78vh] max-w-7xl mx-auto sm:pl-6 sm:pr-6 lg:pl-8 ">


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
                                    <button @click="show_role_modal(role)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 ml-1 p-0"><path fill="#a39163" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM325.8 139.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-21.4 21.4-71-71 21.4-21.4c15.6-15.6 40.9-15.6 56.6 0zM119.9 289L225.1 183.8l71 71L190.9 359.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z"/></svg>
                                    </button>
                                    <button @click="delete_role(role)" class="ml-2">
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
                                <!-- scroll -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[15px] h-[15px]" viewBox="0 0 640 512"><path fill="#fff" d="M48 0C21.53 0 0 21.53 0 48v64c0 8.84 7.16 16 16 16h80V48C96 21.53 74.47 0 48 0zm208 412.57V352h288V96c0-52.94-43.06-96-96-96H111.59C121.74 13.41 128 29.92 128 48v368c0 38.87 34.65 69.65 74.75 63.12C234.22 474 256 444.46 256 412.57zM288 384v32c0 52.93-43.06 96-96 96h336c61.86 0 112-50.14 112-112 0-8.84-7.16-16-16-16H288z"/></svg>
                            </div>
                            <div class="pl-2 font-bold capitalize">{{on_role_mode}} Role</div>
                        </div>
                    </div>
                    <div class="pt-[14px] px-3 sm:px-[23px]">
                        <div class="w-[465px] bg-white border border-harrow-gold-100 rounded-lg text-info-gray-3 h-fit">
                            <div class="w-full h-[80px] flex px-[18px] pt-3 border-b border-harrow-gold-100 justify-center">
                                <BAInputInfo :value="c_role.role_name" @trigger="c_role.role_name=$event">Role Name:</BAInputInfo>
                            </div>
                            <div class="w-full h-fit  px-[18px]">
                                <div v-for="(content, index) in c_role.contents" :key="index" class="h-10 w-full flex items-start pl-[22px] flex-col">
                                    <BASwitch :isOn="content.enabled" :label="content.permission_content_name" @toggle="content.enabled=$event"></BASwitch>
                                </div>
                            </div>
                        </div>                        
                        <div class="flex justify-end">
                            <button class="w-[81px] h-[29px] rounded-md font-bold text-white m-3 border border-[#c3c8d2] bg-[#828282]" @click="cancel_role()">Cancel</button>
                            <button class="w-[81px] h-[29px] rounded-md font-bold text-white mt-3 mb-3 mr-4 border border-[#c3c8d2] bg-harrow-gold-100" @click="save_role()">Save</button>
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
