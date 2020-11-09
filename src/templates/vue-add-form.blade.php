
<template>
  <div id="user-edit-tab-info">
   

    <!-- Content Row -->
    <div class="vx-row">
      <div class="vx-col md:w-1/2 w-full">
        <div class="form-group">
    @foreach($data['fields'] as $field)
                  
    @if($field['simplified_type'] == 'text' && $field['name'] != 'id')
    <vs-input class="w-full mt-4" label="{{ $field['name'] }}" v-model="data_local.{{ $field['name'] }}" type="text" v-validate="required|{{ $field["name"] }}" name="{{ $field['name'] }}" />
                    {{-- <span class="text-danger text-sm" v-show="errors.has('a')">{{
                      errors.first("{{ $field['name'] }}")
                    }}</span> --}}
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

    };
  },

  methods: {
    save_changes() {
      axios
        .post("/api/{{ $data['plural_lower'] }}/add", {
          @foreach($data['fields'] as $field)
          @if($field['name'] != 'created_at' && $field['name'] != 'updated_at' && $field['name'] != 'id')
          {{ $field['name'] }}: this.data_local.{{ $field['name'] }},
          @endif
          @endforeach
        })
        .then((response) => {
          if (response.data.status == "success") {
            this.showUpdateSuccess();
            this.$router.push({ name: "{{ $data['plural_lower'] }}" });
          } else {
            this.showErrorAlert();
          }
        });
    },
    showUpdateSuccess() {
      this.$vs.notify({
        color: "success",
        title: "{{ $data['singular'] }} Added",
        text: "{{ $data['singular'] }} info successfully Added",
      });
    },
    showErrorAlert() {
      this.$vs.notify({
        color: "danger",
        title: "Error",
        text: "{{ $data['singular'] }} Info not Added",
      });
    },
    validateForm() {
      return !this.errors.any();
    },
  },
};
</script>

{{-- 
<template>
      <div class="{{ $data['singular_lower'] }}">
        
        <div class="half">
          
          <h1>Create {{$data['singular_lower']}}</h1>
          
          <form @submit.prevent="create{{ $data['singular'] }}">
            
@foreach($data['fields'] as $field)
            <div class="form-group">
@if($field['name'] == 'id' || $field['name'] == 'updated_at' || $field['name'] == 'created_at' )   
                  <input type="hidden" v-model="form.{{$field['name']}}"></input>
@elseif($field['simplified_type'] == 'text')
                  <label>{{ $field['name'] }}</label>
                  <input type="text" v-model="form.{{$field['name']}}" @if($field['max']) maxlength="{{$field['max']}}" @endif></input>
@if($field['required'] && $field['name'] !== 'id')
                  <has-error :form="form" field="{{$field['name']}}"></has-error>
@endif
@elseif($field['simplified_type'] == 'textarea')
                  <label>{{ $field['name'] }}</label>
                  <textarea v-model="form.{{$field['name']}}" @if($field['max']) maxlength="{{$field['max']}}" @endif></textarea>
@if($field['required'] && $field['name'] !== 'id')
                  <has-error :form="form" field="{{$field['name']}}"></has-error>
@endif
@else
                  <label>{{ $field['name'] }}</label>
                  <input type="number" v-model="form.{{$field['name']}}"></input>
@if($field['required'] && $field['name'] !== 'id')
                  <has-error :form="form" field="{{$field['name']}}"></has-error>
@endif
@endif
            </div>
@endforeach
        
            <div class="form-group">
                <button class="button" type="submit" :disabled="form.busy" name="button">@{{ (form.busy) ? 'Please wait...' : 'Submit'}}</button>
            </div>
          </form>
          
        </div><!-- End first half -->
        
        <div class="half">
          
          <h1>List {{ $data['plural_lower'] }}</h1>
          
          <ul v-if="{{ $data['plural_lower'] }}.length > 0">
            <li v-for="({{ $data['singular_lower'] }},index) in {{ $data['plural_lower'] }}" :key="{{ $data['singular_lower'] }}.id">
              
            <router-link :to="'/{{ $data['singular_lower'] }}/'+{{ $data['singular_lower'] }}.id">
              
              {{ $data['singular_lower']}} @{{ index }}

              <button @click.prevent="delete{{$data['singular']}}({{ $data['singular_lower'] }},index)" type="button" :disabled="form.busy" name="button">@{{ (form.busy) ? 'Please wait...' : 'Delete'}}</button>
              
            </router-link>
              
            </li>
          </ul>
          
          <span v-else-if="!{{ $data['plural_lower'] }}">Loading...</span>
          <span v-else>No {{ $data['plural_lower'] }} exist</span>
          
        </div><!-- End 2nd half -->
        
      </div>
</template>




<script>
import { Form, HasError, AlertError } from 'vform'
export default {
  name: '{{ $data['singular'] }}',
  components: {HasError},
  data: function(){
    return {
      {{ $data['plural_lower'] }} : false,
      form: new Form({
@foreach($data['fields'] as $field)
          "{{$field['name']}}" : "",
@endforeach
      })
    }
  },
  created: function(){
    this.list{{$data['plural']}}();
  },
  methods: {
    list{{ $data['plural'] }}: function(){
      
      var that = this;
      this.form.get('{{config('vueApi.vue_url_prefix')}}/{{ $data['plural_lower'] }}').then(function(response){
        that.{{ $data['plural_lower'] }} = response.data;
      })
      
    },
    create{{ $data['singular'] }}: function(){
      
      var that = this;
      this.form.post('{{config('vueApi.vue_url_prefix')}}/{{ $data['plural_lower'] }}').then(function(response){
        that.{{ $data['plural_lower'] }}.push(response.data);
      })
      
    },
    delete{{$data['singular']}}: function({{ $data['singular_lower'] }}, index){
      
      var that = this;
      this.form.delete('{{config('vueApi.vue_url_prefix')}}/{{ $data['plural_lower'] }}/'+{{ $data['singular_lower'] }}.id).then(function(response){
        that.{{ $data['plural_lower'] }}.splice(index,1);
      })
      
    }
  }
}
</script>

<style lang="less">
.{{ $data['plural_lower'] }}{
    margin:0 auto;
    width:700px;
    display:flex;
    .half{
      flex:1;
      &:first-of-type{
        margin-right:20px;
      }
    }
    form{
      .form-group{
        margin-bottom:20px;
        label{
          display:block;
          margin-bottom:5px;
          text-transform: capitalize;
        }
        input[type="text"],input[type="number"],textarea{
          width:100%;
          max-width:100%;
          min-width:100%;
          padding:10px;
          border-radius:3px;
          border:1px solid silver;
          font-size:1rem;
          &:focus{
            outline:0;
            border-color:blue;
          }
        }
        .invalid-feedback{
          color:red;
          &::first-letter{
            text-transform:capitalize;
          }
        }
      }
      .button{
        appearance: none;
        background: #3bdfd9;
        font-size: 1rem;
        border: 0px;
        padding: 10px 20px;
        border-radius: 3px;
        font-weight: bold;
        &:hover{
          cursor:pointer;
          background: darken(#3bdfd9,10);
        }
      }
    }
}
</style> --}}