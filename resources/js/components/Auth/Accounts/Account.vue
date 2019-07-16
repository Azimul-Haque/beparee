<template>
    <div class="content">
       <div class="content-header" v-if="$gate.isAdminOrAssociated('accounts-page', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">হিসাব-নিকাশ</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><router-link to="/dashboard">স্টোর</router-link></li>
                  <li class="breadcrumb-item active">হিসাব-নিকাশ</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAdminOrAssociated('accounts-page', this.$route.params.code)">
        <!-- <div class="row">
          <div class="col-md-8">
            test
          </div>
          <div class="col-md-4">
            test
          </div>
        </div> -->
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">শেষ সাত দিনের বিক্রয়</div>
              <div class="card-body">
                <chartjs-bar :datalabel="'মোট বিক্রয়মূল্য'" :labels="chartLabel" :data="chartData" :bind="true"></chartjs-bar>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="card-header">Header</div>
              <div class="card-body">
                <chartjs-bar :datasets="types" :datalabel="types.dataLabel" :labels="labels"></chartjs-bar>
                <chartjs-line :labels="mylabels" :datasets="mydatasets"></chartjs-line>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
      <div v-if="!$gate.isAdminOrAssociated('accounts-page', this.$route.params.code)">
          <forbidden-403></forbidden-403>
      </div>
    </div>
    <!-- /.content -->
</template>

<script>

  export default {
    data () {
      return {
        chartLabel: [],
        chartData: [],

        beginZero: true,
        labels: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        types: [
          {
            label: "My first dataset",
            backgroundColor: "rgba(75,192,192,0.5)",
            borderColor: "0c0306",
            data: [1, 3, 5, 7, 2, 4, 6],
            dataLabel: "Bar"
          },
          {
            label: "My first dataset",
            backgroundColor: "rgba(255,0,0,0.5)",
            borderColor: "030c0c",
            data: [1, 5, 2, 6, 3, 7, 4],
            dataLabel: "Baz"
          }
        ],
        mylabels: ["January", "February", "March", "April", "May", "June", "July"],
          mydatasets:[{
              label: "My first dataset",
              fill: false,
              lineTension: 0.1,
              backgroundColor: "rgba(75,192,192,0.4)",
              borderColor: "rgba(255,0,0,1)",
              borderCapStyle: 'butt',
              borderDash: [],
              borderDashOffset: 0.0,
              borderJoinStyle: 'miter',
              pointBorderColor: "rgba(75,192,192,1)",
              pointBackgroundColor: "#fff",
              pointBorderWidth: 1,
              pointHoverRadius: 5,
              pointHoverBackgroundColor: "rgba(75,192,192,1)",
              pointHoverBorderColor: "rgba(220,220,220,1)",
              pointHoverBorderWidth: 1,
              pointRadius: 3,
              pointHitRadius: 10,
              data: [100, 80, 90, 81, 56, 55, 40],
              spanGaps: false,
          },
          {
              label: "My second dataset",
              fill: false,
              lineTension: 0.1,
              backgroundColor: "rgba(75,192,192,0.4)",
              borderColor: "rgba(75,192,192,1)",
              borderCapStyle: 'butt',
              borderDash: [],
              borderDashOffset: 0.0,
              borderJoinStyle: 'miter',
              pointBorderColor: "rgba(75,192,192,1)",
              pointBackgroundColor: "#fff",
              pointBorderWidth: 1,
              pointHoverRadius: 5,
              pointHoverBackgroundColor: "rgba(75,192,192,1)",
              pointHoverBorderColor: "rgba(220,220,220,1)",
              pointHoverBorderWidth: 1,
              pointRadius: 3,
              pointHitRadius: 10,
              data: [110, 85, 99, 41, 66, 25, 80],
              spanGaps: false,
          },],
      }
    },
    methods: {
      loadLastSevenDaysSales() {
        if(this.$gate.isAdminOrAssociated('due-page', this.$route.params.code)){
          axios.get('/api/load/accounts/lastsevendays/sales/' + this.$route.params.code).then((response) => {
            let data = response.data;
            if(data) {
                data.forEach(element => {
                  this.chartData.push(element.total);
                  this.chartLabel.push(element.date);
                  // Labels.push(element.name);
                  // Prices.push(element.price);
                });
                // console.log(this.chartLabel);
            }
            else {
              console.log('No data');
            }
          }); 
        }
      },
    },
    created() {
      this.loadLastSevenDaysSales();
    },
    beforeDestroy() {
      
    }
  }
</script>
