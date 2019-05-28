<template>
    <div class="content">
      <div class="content-header" v-if="$gate.isAuthorized('store-crud')">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">স্টোর</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#!">স্টোর</a></li>
                  <li class="breadcrumb-item active">স্টোর</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAuthorized('store-crud')">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">স্টোর</div>

                    <div class="card-body">
                        {{ this.$route.params.token }}
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div v-if="!$gate.isAuthorized('store-crud')">
          <forbidden-403></forbidden-403>
      </div>
    </div>
</template>

<script>
  export default {
    methods: {
      loadStore() {

      }
    },
    created() {
      this.loadStore();
      console.log(this.$route.params.token);
    }
  }
</script>
