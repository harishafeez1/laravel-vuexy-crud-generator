<template>
  <div id="page-{{$data['singular_lower']}}-view">
   

    <div id="{{$data['singular_lower']}}-data" v-if="{{$data['singular_lower']}}_data">
    <vx-card title="{{$data['singular']}}" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row">
          

          <!-- Information - Col 1 -->
          <div class="vx-col flex-1" id="account-info-col-1">
            <table>
              @foreach ($data['fields'] as $field)
              <tr>
              <td class="font-semibold">{{ucfirst($field['name'])}}</td>
                <td>@{{ @php echo $data['singular_lower']@endphp_data.@php echo $field['name'] @endphp }}</td>
            </tr>
            @endforeach
            </table>
          </div>
        
          <div class="vx-col w-full flex" id="account-manage-buttons">
            <vs-button
              icon-pack="feather"
              icon="icon-edit"
              class="mr-4"
              :to="{
                name: '{{$data['plural_lower']}}-edit',
                params: { id: $route.params.id },
              }"
              >Edit</vs-button
            >
            <vs-button
              type="border"
              color="danger"
              icon-pack="feather"
              icon="icon-trash"
              @click="confirmDeleteRecord"
              >Delete</vs-button
            >
          </div>
        </div>
      </vx-card>

    </div>
  </div>
</template>

<script>

import axios from "@/axios.js";

export default {
  data() {
    return {
      {{$data['singular_lower']}}_data: null,
      {{$data['singular_lower']}}_not_found: false,
    };
  },
  computed: {
  },
   
  mounted: function () {
    this.get{{ucfirst($data['singular_lower'])}}();
  },
  methods: {
    get{{ucfirst($data['singular_lower'])}}: function () {
      axios
        .get("/api/{{$data['plural_lower']}}/view/" + this.$route.params.id)
        .then((response) => {
          this.{{$data['singular_lower']}}_data = response.data;
        })
        .catch(function (e) {
          if (e.response && e.response.status == 404) {
            that.$router.push("/404");
          }
        });
    },
    confirmDeleteRecord() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Confirm Delete",
        text: `You are about to delete "${this.{{$data['singular_lower']}}_data.id}"`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    deleteRecord() {
    
      axios.get(`/api/{{$data['plural_lower']}}/delete/${this.{{$data['singular_lower']}}_data.id}`).then( response => {
        this.showDeleteSuccess();
        this.$router.push({name: '{{$data['plural_lower']}}'});
      }).catch(function(e) {
       
         
      })
    },
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "{{ucfirst($data['singular_lower'])}} Deleted",
        text: "The selected {{ucfirst($data['singular_lower'])}} was successfully deleted",
      });
    },
    showDeleteError() {
      this.$vs.notify({
        color: "danger",
        title: "{{ucfirst($data['singular_lower'])}} Not Deleted",
        text: "Error while Deleting {{ucfirst($data['singular_lower'])}}",
      });
    },
  },
};
</script>

<style lang="scss">
#avatar-col {
  width: 10rem;
}

#page-{{$data['singular_lower']}}-view {
  table {
    td {
      vertical-align: top;
      min-width: 140px;
      padding-bottom: 0.8rem;
      word-break: break-all;
    }

    &:not(.permissions-table) {
      td {
        @media screen and (max-width: 370px) {
          display: block;
        }
      }
    }
  }
}

@media screen and (min-width: 1201px) and (max-width: 1211px),
  only screen and (min-width: 636px) and (max-width: 991px) {
  #account-info-col-1 {
    width: calc(100% - 12rem) !important;
  }
}
</style>
