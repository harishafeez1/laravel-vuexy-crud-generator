<template>
  <div id="page-{{ $data['singular_lower'] }}-list">
    <div class="vx-card p-6">
      <div class="vx-card p-6">
      <div class="flex flex-wrap items-center">
        <!-- Left -->
        <div class="flex-grow">
          {{-- <vs-button class="mb-4 md:mb-0" @click="$router.push({name: '{{ $data['plural_lower'] }}-add'})"
            >Add {{ $data['singular'] }}</vs-button
          > --}}
        </div>
        <!-- Right -->
        <vs-button class="mb-4 md:mb-0" @click="$router.push({name: '{{ $data['plural_lower'] }}-add'})"
            >Add {{ $data['singular'] }}</vs-button
          >
      </div>
      <table-view :tableObj="tobj" />
      </div>
    </div>
  </div>
</template>
<script>
import TableView from "../table/TableView.vue";

export default {
  data() {
    return {
      tobj: {
        url: "/api/{{ $data['plural_lower'] }}",
        headings: {
          @foreach($data['fields'] as $field)
          @if($field['name'] != 'created_at' && $field['name'] != 'updated_at')
           {{ucwords($field['name'])  }}: "{{ $field['name'] }}",
          @endif
          @endforeach
           Action: {
            edit: "/{{ $data['plural_lower'] }}/edit/",
            del: "/api/{{ $data['plural_lower'] }}/delete/",
            view: "/{{ $data['plural_lower'] }}/view/",
          },
          },
        },
     
  };
  },
  components: {
    TableView,
  },
};
</script>

<style lang="scss">
#page-{{ $data['singular_lower'] }}-list {
  .{{ $data['singular_lower'] }}-list-filters {
    .vs__actions {
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-58%);
    }
  }
}
</style>

