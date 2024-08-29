import './bootstrap';
window.Echo.channel('dashboard').listen('DashboardDataUpdated', function (event) {
  document.getElementById('totalOrders').innerText = event.data.totalOrders;
  document.getElementById('completedOrders').innerText = event.data.completedOrders;
  document.getElementById('shippedOrders').innerText = event.data.shippedOrders;
  document.getElementById('processingOrders').innerText = event.data.processingOrders;
  document.getElementById('declinedOrders').innerText = event.data.declinedOrders;
  document.getElementById('topCategory').innerText = event.data.topCategory ? event.data.topCategory.category_id : '-';
  document.getElementById('mostSoldProduct').innerText = event.data.mostSoldProduct ? event.data.mostSoldProduct.product_id : '-';
});
