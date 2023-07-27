import { ref, watch, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

export default function (params) {
    const { filters: defaultFilters, routeResourceName } = params;

    const filters = ref(defaultFilters);

    const fetchItemHandler = ref(null);



    function fetchItems() {
        router.get(route(`admin.${routeResourceName}.index`), filters.value, {
            preserveState: true,
            preserveScroll: true,
            replace: true
        })
    };

    watch(filters, () => {
        clearTimeout(fetchItemHandler.value);
        fetchItemHandler.value = setTimeout(() => {
            fetchItems();
        }, 500);
    }, {
        deep: true
    });

    return {
        filters
    }
}
