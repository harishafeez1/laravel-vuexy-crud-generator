
<template>
  <div id="page-{{$data['singular_lower']}}-edit">
    <vs-alert
      color="danger"
      title="{{$data['singular']}} Not Found"
      :active.sync="{{$data['singular_lower']}}_not_found"
    >
      {{-- <span>{{$data['singular']}} record with id: "{{ $route.params.userId }}" not found. </span> --}}
      <span>
        <span>Check </span
        ><router-link
          :to="{ name: 'page-{{$data['plural_lower']}}-list' }"
          class="text-inherit underline"
          >All {{$data['singular']}}</router-link
        >
      </span>
    </vs-alert>

    <vx-card>
      <div slot="no-body" class="tabs-container px-6 pt-6">
        <vs-tabs v-model="activeTab" class="tab-action-btn-fill-conatiner">
          <vs-tab label="Add {{$data['singular']}}" icon-pack="feather" icon="icon-user">
            <div class="tab-text">
              <{{$data['singular_lower']}}-add-form />
            </div>
          </vs-tab>
        </vs-tabs>
      </div>
    </vx-card>
  </div>
</template>

<script>
// Store Module
import {{$data['singular']}}AddForm from "./{{$data['singular']}}AddForm.vue"; 
import axios from "@/axios.js";
export default {
  data() {
    return {
      {{$data['singular_lower']}}: null,
      {{$data['singular_lower']}}_not_found: false,

      /*
        This property is created for fetching latest data from API when tab is changed

        Please check it's watcher
      */
      activeTab: 0,
    };
  },

  components: {
    {{$data['singular']}}AddForm, 
  },
};
</script>

