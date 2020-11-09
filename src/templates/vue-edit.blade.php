<template>
<div id="page-{{$data['singular_lower']}}-edit">
  
      <vx-card >
  
        <div slot="no-body" class="tabs-container px-6 pt-6">
  
          <vs-tabs v-model="activeTab" class="tab-action-btn-fill-conatiner">
            <vs-tab label="Edit {{$data['singular']}}" icon-pack="feather" icon="icon-user">
              <div class="tab-text">
               <{{$data['singular_lower']}}-edit-form/>
              </div>
            </vs-tab>
            
          </vs-tabs>
  
        </div>
  
      </vx-card>
    </div>
  </template>
  
  <script>
  
  
  // Store Module
  import {{$data['singular']}}EditForm from './{{$data['singular']}}EditForm.vue';
  import axios from "@/axios.js";
  export default {
    
    data () {
      return {
        /*
          This property is created for fetching latest data from API when tab is changed
  
          Please check it's watcher
        */
        activeTab: 0
      }
    },
    
    components:{
        {{$data['singular']}}EditForm
    },
   
  }
  
  </script>
  