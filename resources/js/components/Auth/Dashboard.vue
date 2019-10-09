<template>
    <div class="content">
      <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">ড্যাশবোর্ড</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#!">ড্যাশবোর্ড</a></li>
                  <li class="breadcrumb-item active">ড্যাশবোর্ড</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4" v-for="store in stores">
                <a :href="'/store/' + store.token + '/' + store.code" class="card card-widget widget-user">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header bg-info-active" style="background: url('/images/storecover.jpg') center center;">
                    <p class="shadow text-light" style="background: rgba(251, 251, 251, 0.35); padding: 5px;">{{ store.slogan }}</p>
                  </div>
                  <div class="widget-user-image">
                    <img class="img-circle elevation-2" :src="getStoreMonogram(store.monogram)" alt="User Avatar">
                  </div>
                  <div class="card-footer">
                    <div class="description-block">
                      <h3 class="description-header">{{ store.name }}</h3>
                      <h6 class="widget-user-desc">দোকান কোডঃ {{ store.code }}</h6>
                      <span class="description-text">
                        {{ store.address }}<br/>
                        {{ store.upazilla }}, {{ store.district }}
                      </span>
                    </div>
                  </div>
                </a>
            </div>
        </div>
      </div>
    </div>
</template>

<script>
    export default {
      data () {
        return {
          stores: {},
        }
      },
      methods: {
        loadStores() {
          var user_parsed = JSON.parse(this.$user);
          var user_id = user_parsed.id;
          axios.get('/api/load/stores/for/dashboard/' + user_id).then(({ data }) => (this.stores = data));
        },
        getStoreMonogram(monogram) {
          if(monogram == null) {
            return '/images/default_store.png';
          } else {
            if(monogram.length > 0) {
              return '/images/stores/' + monogram;
            } else {
              return '/images/default_store.png';
            }
          }
        },
      },
      created() {
        this.loadStores();
      }
    }
</script>
