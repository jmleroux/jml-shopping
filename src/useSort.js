import { ref } from "vue";

export default function useSort(initialSortField) {
  const sortField = ref(initialSortField);
  const sortDirection = "asc";

  const changeSort = (fieldName) => {
    sortField.value = fieldName;
  };

  const sortIconClass = (fieldName) => {
    const iconClass =
      "asc" === sortDirection ? "bi bi-caret-down" : "bi bi-caret-up";

    return fieldName === sortField.value ? iconClass : "";
  };


  return {
    sortField,
    sortIconClass,
    changeSort,
  }
}
