import moment from 'moment'
import Vue from 'vue'

Vue.filter('date', function(date) {
  return moment(date).format('MMMM DD, YYYY');
})

Vue.filter('datetime', function(date) {
	return moment(date).format('MMMM DD, YYYY hh:mm A');
})

Vue.filter('activation_status', function(activation_status) {
	if(activation_status == 0) {
		return 'প্রক্রিয়াধীন';
	} else {
		return 'অনুমোদিত';
	}
})

Vue.filter('payment_status', function(payment_status) {
	if(payment_status == 0) {
		return 'অপরিশোধিত';
	} else {
		return 'পরিশোধিত';
	}
})

Vue.filter('totalquantity', function(data) {
  var totalquantity = 0;
  if(data) {
    for(var i=0; i<data.length; i++) {
      totalquantity = totalquantity + parseInt(data[i].current_quantity);
    }
  }
  return totalquantity;
})
