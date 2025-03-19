<template>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center border-0 text-center mb-3">
        <h3 class="text-center flex-grow-1" style="color: rgba(10, 19, 58, 1); font-weight: 700; font-size:1.4rem; margin-bottom: 0 !important">
            Scientific References
        </h3>
        <button type="button" class="btn-close btn-pinned btn-right me-3" :data-bs-target="'#flow-' + id" data-bs-toggle="modal" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <!-- Body -->
    <div class="modal-body">
        <div v-for="reference in references" :key="reference.id" class="reference-item d-flex align-items-center gap-3 mb-3">
            <div>
                {{ reference.title }}
            </div>
            <a :href="reference.link" target="_blank" class="btn mh-btn ms-auto" style="text-wrap: nowrap;">View Publication</a>
        </div>
    </div>

    <!-- Footer with more spacing -->
    <div class="d-flex justify-content-between align-items-center border-0 text-center mt-4">
        <button class="btn mh-btn" :data-bs-target="'#flow-' + id" data-bs-toggle="modal" data-bs-dismiss="modal">Back</button>
    </div>
</template>

<script>
import { ref } from "vue";

export default {
    setup() {
        const id = ref(0);
        const references = ref([]);

        window.showReferences = (refId, refs) => {
            console.log(refs);
            id.value = refId;
            references.value = JSON.parse(refs);
        };

        return {
            id,
            references
        };
    }
};
</script>
