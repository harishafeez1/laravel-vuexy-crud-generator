
<template>
<div id="{{$data['singular_lower']}}-edit-tab-info">
      <!-- Avatar Row -->
      <div class="vx-row">
        <div class="vx-col w-full"></div>
      </div>
  
      <!-- Content Row -->
      <div class="vx-row">
        <div class="vx-col md:w-1/2 w-full">
            @foreach($data['fields'] as $field)
                  
            @if($field['simplified_type'] == 'text' && $field['name'] != 'id')
            <vs-input class="w-full mt-4" label="{{ $field['name'] }}" v-model="data_local.{{ $field['name'] }}" type="text" v-validate="required|{{ $field["name"] }}" name="{{ $field['name'] }}" />
             <span class="text-danger text-sm" v-show="errors.has('@php echo $field['name']@endphp')">{{
                              errors.first("{{ $field['name'] }}")
                            }}</span>
            @endif
            @if($field['simplified_type'] == 'number' && $field['name'] != 'created_at' && $field['name'] != 'updated_at' && $field['name'] != 'id')
            @if($field['type'] == 'tinyint')
            
            <template>
              <div class="prepend-text mt-6 ml-auto">
                <span class="switch-label">{{ $field['name'] }}</span>
                <vs-switch v-model="data_local.{{ $field['name'] }}" />
              </div>
            </template>
            @else
            <vs-input class="w-full mt-4" label="{{ $field['name'] }}" v-model="data_local.{{ $field['name'] }}" type="number" v-validate="required|{{ $field["name"] }}" name="{{ $field['name'] }}" />
        
            
            @endif
        
            @endif
            @endforeach
  
       
        </div>
      </div>
  
      <!-- Save & Reset Button -->
      <div class="vx-row">
        <div class="vx-col w-full">
          <div class="mt-8 flex flex-wrap items-center justify-end">
            <vs-button
              class="ml-auto mt-2"
              @click="save_changes"
              :disabled="!validateForm"
              >Save Changes</vs-button
            >
          </div>
        </div>
      </div>
    </div>
</template>
  
  <script>
  import axios from "@/axios.js";
  export default {
    data() {
      return {
        data_local: [],
  
  
        activeTab: 0,
        status: false,
      };
    },
    watch: {
      activeTab() {
        this.fetch_data();
      },
    },
    methods: {
      fetch_data() {
        axios
          .get("/api/{{$data['plural_lower']}}/edit/" + this.$route.params.id)
          .then((response) => {
            this.data_local = response.data;
           
          });
      },
      save_changes() {
  
          axios
          .post("/api/{{$data['plural_lower']}}/update/" + this.$route.params.id,
          {
            @foreach($data['fields'] as $field)
          @if($field['name'] != 'created_at' && $field['name'] != 'updated_at' && $field['name'] != 'id')
          {{ $field['name'] }}: this.data_local.{{ $field['name'] }},
          @endif
          @endforeach
          })
          .then((response) => {
            this.showUpdateSuccess();
            this.$router.push({ name: "{{$data['plural_lower']}}" });
          });
      },
      showUpdateSuccess() {
        this.$vs.notify({
          color: "success",
          title: "{{$data['singular']}} Updated",
          text: "{{$data['singular']}} info successfully Updated",
        });
      },
      validateForm() {
        return !this.errors.any();
      },
    },
  
    mounted: function () {
      this.fetch_data();
    },
  };
  </script>