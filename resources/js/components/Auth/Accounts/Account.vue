<template>
    <div class="content" id="pageId">
       <div class="content-header" v-if="$gate.isAdminOrAssociated('accounts-page', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">হিসাব-নিকাশ একনজরে</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><router-link to="/dashboard">স্টোর</router-link></li>
                  <li class="breadcrumb-item active">হিসাব-নিকাশ একনজরে</li>
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
              <div class="card-header">
                শেষ সাত দিনের বিক্রয়
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm noprint" @click="printLastSevenDays()" v-tooltip="'প্রিন্ট করুন'">
                      <i class="fa fa-print"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <chartjs-bar :datalabel="'মোট বিক্রয়মূল্য'" 
                             :labels="chartLastSvnLabel" 
                             :data="chartLastSvnData" 
                             :backgroundcolor="'rgba(21,101,192,0.5)'"
                             :bordercolor="'0D47A1'"
                             :height="140" 
                             :bind="true"
                             ref="lastSevenDays"></chartjs-bar>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                {{ thisYear }} সালের মাসভিত্তিক লাভ
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm noprint" @click="printThisYears(thisYear)" v-tooltip="'প্রিন্ট করুন'">
                      <i class="fa fa-print"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <chartjs-line :labels="chartThisYrPrftLabel"
                              :datasets="chartThisYrPrftData"
                              :height="140" 
                              :bind="true"
                              ref="thisYears"></chartjs-line>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            {{ thisMonth }}-এর ক্রয় ও বিক্রয়ের তুলনা
            <div class="card-tools">
              <button type="button" class="btn btn-primary btn-sm noprint" @click="printThisMonths(thisMonth)" v-tooltip="'প্রিন্ট করুন'">
                  <i class="fa fa-print"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <chartjs-bar :datasets="chartProfitCalcThisMonthData" :labels="chartProfitCalThisMonthcLabel" :bind="true" :height="75" ref="thisMonths"></chartjs-bar>
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
  import moment from 'moment'

  export default {
    data () {
      return {
        thisYear: moment(new Date()).format('YYYY'),
        thisMonth: moment(new Date()).format('MMMM YYYY'),

        chartLastSvnLabel: [],
        chartLastSvnData: [],

        chartThisYrPrftLabel: [],
        chartThisYrPrftData: [
          {
            label: "লাভ",
            fill: true,
            data: [],
            lineTension: 0,
            backgroundColor: "rgba(75,192,192,0.2)",
            borderColor: "rgba(104,159,56,1)",
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
            spanGaps: false,
          }
        ],
        
        chartProfitCalThisMonthcLabel: [],
        chartProfitCalcThisMonthData: [
          {
            label: "মোট ক্রয়মূল্য",
            backgroundColor: "rgba(139,195,74,0.5)",
            borderColor: "0c0306",
            data: [],
            dataLabel: "Bar"
          },
          {
            label: "মোট বিক্রয়মূল্য",
            backgroundColor: "rgba(0,150,136,0.5)",
            borderColor: "030c0c",
            data: [],
            dataLabel: "Baz"
          }
        ],
      }
    },
    methods: {
      loadLastSevenDaysSales() {
        if(this.$gate.isAdminOrAssociated('due-page', this.$route.params.code)){
          axios.get('/api/load/accounts/lastsevendays/sales/' + this.$route.params.code).then((response) => {
            let data = _.sortBy(response.data, 'date');
            if(data) {
                data.forEach(element => {
                  this.chartLastSvnLabel.push(moment(element.date).format('MMM DD'));
                  this.chartLastSvnData.push(element.total);
                });
                // console.log(this.chartLastSvnLabel);
            }
            else {
              console.log('No data');
            }
          }); 
        }
      },
      loadThisYearsProfit() {
        if(this.$gate.isAdminOrAssociated('due-page', this.$route.params.code)){
          axios.get('/api/load/accounts/thisyears/profit/' + this.$route.params.code).then((response) => {
            let data = response.data;
            if(data) {
                data.forEach(element => {
                  this.chartThisYrPrftLabel.push(element.date);
                  this.chartThisYrPrftData[0].data.push((element.total - element.cost).toFixed(2));
                });
                // console.log(this.chartThisYrPrftData);
            }
            else {
              console.log('No data');
            }
          }); 
        }
      },
      loadProfitCacl() {
        if(this.$gate.isAdminOrAssociated('due-page', this.$route.params.code)){
          axios.get('/api/load/accounts/profit/calc/this/month/' + this.$route.params.code).then((response) => {
            let data = response.data;
            if(data) {
                data.forEach(element => {
                  this.chartProfitCalThisMonthcLabel.push(element.date);
                  this.chartProfitCalcThisMonthData[0].data.push(element.cost);
                  this.chartProfitCalcThisMonthData[1].data.push(element.total);
                });
                // console.log(this.chartProfitCalcThisMonthData);
            }
            else {
              console.log('No data');
            }
          }); 
        }
      },
      printLastSevenDays() {
        const canvasEle = this.$refs.lastSevenDays.$el.querySelector('canvas').toDataURL('image/png', 1.0);
        var win = window.open('', 'Print', 'height=800,width=1000');
        win.document.write("<h2>শেষ সাত দিনের বিক্রয়</h2><br/><img src='" + canvasEle + "' /><br/><br/><br/>Powered by ব্যাপারী");
        setTimeout(function(){ //giving it 200 milliseconds time to load
                win.document.close();
                win.focus()
                win.print();
                win.location.reload()
                win.close();
        }, 200); 
      },
      printThisYears(year) {
        const canvasEle = this.$refs.thisYears.$el.querySelector('canvas').toDataURL('image/png', 1.0);
        var win = window.open('', 'Print', 'height=800,width=1000');
        win.document.write("<h2>"+year+" সালের মাসভিত্তিক লাভ</h2><br/><img src='" + canvasEle + "' /><br/><br/><br/>Powered by ব্যাপারী");
        setTimeout(function(){ //giving it 200 milliseconds time to load
                win.document.close();
                win.focus()
                win.print();
                win.location.reload()
                win.close();
        }, 200); 
      },
      printThisMonths(month) {
        const canvasEle = this.$refs.thisMonths.$el.querySelector('canvas').toDataURL('image/png', 1.0);
        var win = window.open('', 'Print', 'height=800,width=1000');
        win.document.write("<h2>"+month+" এর ক্রয় ও বিক্রয়ের তুলনা</h2><br/><img src='" + canvasEle + "' /><br/><br/><br/>Powered by ব্যাপারী");
        setTimeout(function(){ //giving it 200 milliseconds time to load
                win.document.close();
                win.focus()
                win.print();
                win.location.reload()
                win.close();
        }, 200); 
      },
    },
    created() {
      this.loadLastSevenDaysSales();
      this.loadThisYearsProfit();
      this.loadProfitCacl();
    },
    beforeDestroy() {
      
    }
  }
</script>
