export const categoryName = (state, categoryId) => {
    if (null === categoryId) {
        return '';
    }
    const category = state.categories.find(category => category.id === categoryId);
    return category.name;
}

export const sortProducts = (state, list) => {
    list.sort((p1, p2) => {
        if (categoryName(state, p1.category_id) > categoryName(state, p2.category_id)) {
            return 1;
        }
        if (categoryName(state, p1.category_id) < categoryName(state, p2.category_id)) {
            return -1;
        }
        return p1.name.toLowerCase() > p2.name.toLowerCase() ? 1 : -1;
    });
    return list;
}
