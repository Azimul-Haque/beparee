<template>
    <div class="content">
        <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 text-dark">404 Not Found</h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><router-link to="/dashboard">ড্যাশবোর্ড</router-link></li>
                    <li class="breadcrumb-item active">404 Not Found</li>
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
                        <div class="card-header">আপনি যা খুঁজছেন তা পাওয়া যায়নি!</div>

                        <div class="card-body">
                            <center>
                                <img src="/images/undraw_page_not_found_su7k.svg"  class="img-fluid">
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
