<template>
<input  class="form-control" 
        :type="type" 
        :placeholder="label" 
        :value="value" 
        :required="required" 
        :readonly="readonly" 
        :disabled="disabled" 
        :autoComplete="autoComplete" 
        :minlength="minlength" 
        :max="maxlength"
        @input="handleInput($event.target.value)" 
        @focus="handleFocus"
        @blur="handleBlur"
    >
</template>

<script>
export default {
    name: 'BasicInput',
    props: {
        id: {
            type: String
        },
        label: {
            type: String,
            required: true
        },
        value: {
            type: [String,Number],
        },
        required: {
            type: Boolean,
            default: false,
        },
        type: {
            type: String,
            required: true,
            default: 'text'
        },
        readonly: Boolean,
        disabled: Boolean,
        minlength: Number,
        maxlength: Number,
        autoComplete: {
            type: String,
            default: 'off',
        },
    },
    data() {
        return {
            focus: false
        }
    },
    methods: {
        handleInput(value) {
            this.$emit('input', value)
        },
        handleFocus(value) {
            this.focus = true;
            this.$emit('focus', value);
        },
        handleBlur(value) {
            this.focus = false;
            this.$emit('blur', value);
        }
    },

}
</script>
