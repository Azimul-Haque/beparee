<template>
    <div class="content">
        <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 text-dark">403 Forbidden</h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><router-link to="/dashboard">ড্যাশবোর্ড</router-link></li>
                    <li class="breadcrumb-item active">403 Forbidden</li>
                  </ol>
                </div>
              </div>
            </div>
        </div>
        <!-- Header content -->
      
        <!-- /.content-header -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">এই পাতাটি আপনার জন্য অনতিক্রম্য</div>

                        <div class="card-body">
                            <center>
                                <img src="/images/undraw_cancel_u1it.svg"  class="img-fluid">
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
