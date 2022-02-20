// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
try{
  var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ["MOBILE", "PC"],
      datasets: [{
        data: pc_mobile_array,
        backgroundColor: ['lightpink','#4e73df'],
        hoverBackgroundColor: ['pink', 'blue'],
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }],
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 30,
        yPadding: 30,
        displayColors: false,
        caretPadding: 10,
        weight: 150,
      },
      legend: {
        display: false
      },
      cutoutPercentage: 80,
    },
  });
}
catch(error){
  var s = 'wait';
}
