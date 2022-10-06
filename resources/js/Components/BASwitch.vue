<script>
    import { toRefs, ref, watch } from 'vue'

    export default {
        props: ['state', 'label'],
        setup(props) {
            const { state }  = toRefs(props)
            const innerState = ref('');
            
            watch(state, (x) => {
                innerState.value = x;
            });

            return { innerState }
        },
        methods: {
            changeVal() {
                this.innerState = !this.innerState
                console.log( this.innerState )
                this.$emit('changeVal', this.innerState )
            }
        },
    }
</script>

<template>
    <div class="flex ">
        <div class="flex">
            <div class="p-0 mt-[12px] mx-2 ">
                <button @click="changeVal()" class="px-[1px] w-9 h-5 shadow-inner rounded-full border" :class="innerState==true ? 'bg-harrow-gold-100 text-right' : 'bg-gray-300 text-left'">
                    <button class="w-4 h-4 shadow-md rounded-full bg-white">
                    </button>
                </button>
            </div>
        </div>
        <div class="text-gray-400 text-sm leading-loose pt-[8px]">{{label}}</div>
    </div>
</template>
