import { computed, reactive } from 'vue'

const state = reactive({
    showProductHint: true,
    showProductForm: true,
    showPreselectionHint: true,
})

export default () => ({
    showProductHint: computed(() => state.showProductHint),
    showProductForm: computed(() => state.showProductForm),
    showSelectionHint: computed(() => state.showPreselectionHint),
    hideProductHint: () => { Object.assign(state, { showProductHint: false }) },
    toggleProductForm: () => { Object.assign(state, { showProductForm: !state.showProductForm }) },
    hideSelectionHint: () => { Object.assign(state, { showPreselectionHint: false }) },
})
