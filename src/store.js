import { computed, reactive } from 'vue'

const state = reactive({
    showProductHint: true,
    showProductForm: true,
    showPreselectionHint: true,
    showChecked: true,
})

export default () => ({
    showProductHint: computed(() => state.showProductHint),
    showProductForm: computed(() => state.showProductForm),
    showSelectionHint: computed(() => state.showPreselectionHint),
    showChecked: computed({
        get() {
            return state.showChecked
        },
        set(value) {
            state.showChecked = value
        }
    }),
    hideProductHint: () => { Object.assign(state, { showProductHint: false }) },
    toggleProductForm: () => { Object.assign(state, { showProductForm: !state.showProductForm }) },
    hideSelectionHint: () => { Object.assign(state, { showPreselectionHint: false }) },
})
