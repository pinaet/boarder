<script >
    // defineProps(['value','label','type']);
    // // console.log(this.$props.value)
    // const update = function(){
    //     // alert(this.props.value)
    //     this.$emit('update')
    // }
    export default {
        props: {
            value: String,
            label: String,
            type: String,
            form: String,
        },
        methods: {
            changeUsername() {
                console.log( this.value )
                this.$emit('changeUsername', this.value )
            }
        }
    }
</script>

<template>
    <div class="relative h-[57px] w-[326px] text-left font-['Arial'] leading-[normal]">
        <div class="inline-flex">
            <div class="absolute inset-x-0 bottom-0 top-[15.79%] rounded-[5px] border border-solid  border-[rgba(189,189,189,1)] bg-[rgba(248,248,248,1)]" />
        </div>
        <div class="inline-flex text-base font-bold text-[rgba(79,79,79,1)]">
            <input class="absolute border-none top-[9px] bg-inherit w-full border-1 h-[48px] rounded-[5px]" :type="type" v-model="value" @change="changeUsername()" :autocomplete="form=='true'? true : false "/>
        </div>
        <div class="inline-flex text-sm font-normal text-[rgba(130,130,130,1)]">
            <div class="absolute left-2.5 -top-px flex items-start gap-2.5 bg-white px-px py-py">
                <p>{{label}}</p>
            </div>
        </div>
    </div>
</template>
