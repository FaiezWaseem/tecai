

$(function () {
    'use strict'
  
    // Make the dashboard widgets sortable Using jquery UI
    $('.connectedSortable').sortable({
      placeholder: 'sort-highlight',
      connectWith: '.connectedSortable',
      handle: '.card-header, .nav-tabs',
      forcePlaceholderSize: true,
      zIndex: 999999
    })
    $('.connectedSortable .card-header').css('cursor', 'move')
  
    // jQuery UI sortable for the todo list
    $('.todo-list').sortable({
      placeholder: 'sort-highlight',
      handle: '.handle',
      forcePlaceholderSize: true,
      zIndex: 999999
    })
  
    // bootstrap WYSIHTML5 - text editor
    $('.textarea').summernote()
  
    $('.daterange').daterangepicker({
      ranges: {
        Today: [moment(), moment()],
        Yesterday: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment().subtract(29, 'days'),
      endDate: moment()
    }, function (start, end) {
      // eslint-disable-next-line no-alert
      alert('You chose: ' + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    })
  
    /* jQueryKnob */
    $('.knob').knob()
  
    // jvectormap data
    var visitorsData = {
      US: 398, // USA
      SA: 400, // Saudi Arabia
      CA: 1000, // Canada
      DE: 500, // Germany
      FR: 760, // France
      CN: 300, // China
      AU: 700, // Australia
      BR: 600, // Brazil
      IN: 800, // India
      GB: 320, // Great Britain
      RU: 3000 // Russia
    }
    // World map by jvectormap
    $('#world-map').vectorMap({
      map: 'usa_en',
      backgroundColor: 'transparent',
      regionStyle: {
        initial: {
          fill: 'rgba(255, 255, 255, 0.7)',
          'fill-opacity': 1,
          stroke: 'rgba(0,0,0,.2)',
          'stroke-width': 1,
          'stroke-opacity': 1
        }
      },
      series: {
        regions: [{
          values: visitorsData,
          scale: ['#ffffff', '#0154ad'],
          normalizeFunction: 'polynomial'
        }]
      },
      onRegionLabelShow: function (e, el, code) {
        if (typeof visitorsData[code] !== 'undefined') {
          el.html(el.html() + ': ' + visitorsData[code] + ' new visitors')
        }
      }
    })
  
    // Sparkline charts
    var sparkline1 = new Sparkline($('#sparkline-1')[0], { width: 80, height: 50, lineColor: '#92c1dc', endColor: '#ebf4f9' })
    var sparkline2 = new Sparkline($('#sparkline-2')[0], { width: 80, height: 50, lineColor: '#92c1dc', endColor: '#ebf4f9' })
    var sparkline3 = new Sparkline($('#sparkline-3')[0], { width: 80, height: 50, lineColor: '#92c1dc', endColor: '#ebf4f9' })
  
    sparkline1.draw([1000, 1200, 920, 927, 931, 1027, 819, 930, 1021])
    sparkline2.draw([515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921])
    sparkline3.draw([15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21])
  
    // The Calender
    $('#calendar').datetimepicker({
      format: 'L',
      inline: true
    })
  
    // SLIMSCROLL FOR CHAT WIDGET
    $('#chat-box').overlayScrollbars({
      height: '250px'
    })
  
    /* Chart.js Charts */
    // Sales chart
    var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d')
    // $('#revenue-chart').get(0).getContext('2d');
  
    var salesChartData = {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label: 'Digital Goods',
          backgroundColor: 'rgba(60,141,188,0.9)',
          borderColor: 'rgba(60,141,188,0.8)',
          pointRadius: false,
          pointColor: '#3b8bba',
          pointStrokeColor: 'rgba(60,141,188,1)',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data: [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label: 'Electronics',
          backgroundColor: 'rgba(210, 214, 222, 1)',
          borderColor: 'rgba(210, 214, 222, 1)',
          pointRadius: false,
          pointColor: 'rgba(210, 214, 222, 1)',
          pointStrokeColor: '#c1c7d1',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data: [65, 59, 80, 81, 56, 55, 40]
        }
      ]
    }
  
    var salesChartOptions = {
      maintainAspectRatio: false,
      responsive: true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines: {
            display: false
          }
        }],
        yAxes: [{
          gridLines: {
            display: false
          }
        }]
      }
    }
  
    // This will get the first returned node in the jQuery collection.
    // eslint-disable-next-line no-unused-vars
    var salesChart = new Chart(salesChartCanvas, { // lgtm[js/unused-local-variable]
      type: 'line',
      data: salesChartData,
      options: salesChartOptions
    })

    // Sales graph chart
    var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
    // $('#revenue-chart').get(0).getContext('2d');
  
    var salesGraphChartData = {
      labels: ['2011 Q1', '2011 Q2', '2011 Q3', '2011 Q4', '2012 Q1', '2012 Q2', '2012 Q3', '2012 Q4', '2013 Q1', '2013 Q2'],
      datasets: [
        {
          label: 'Digital Goods',
          fill: false,
          borderWidth: 2,
          lineTension: 0,
          spanGaps: true,
          borderColor: '#efefef',
          pointRadius: 3,
          pointHoverRadius: 7,
          pointColor: '#efefef',
          pointBackgroundColor: '#efefef',
          data: [2666, 2778, 4912, 3767, 6810, 5670, 4820, 15073, 10687, 8432]
        }
      ]
    }
  
    var salesGraphChartOptions = {
      maintainAspectRatio: false,
      responsive: true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          ticks: {
            fontColor: '#efefef'
          },
          gridLines: {
            display: false,
            color: '#efefef',
            drawBorder: false
          }
        }],
        yAxes: [{
          ticks: {
            stepSize: 5000,
            fontColor: '#efefef'
          },
          gridLines: {
            display: true,
            color: '#efefef',
            drawBorder: false
          }
        }]
      }
    }
  
    // This will get the first returned node in the jQuery collection.
    // eslint-disable-next-line no-unused-vars
    var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
      type: 'line',
      data: salesGraphChartData,
      options: salesGraphChartOptions
    })
  })



  function loadStudentCanvas(data = [100, 78,22]){
    var studentchartCanvas = $('#students-chart-canvas').get(0).getContext('2d')
    var Options = {
      legend: {
        display: false
      },
      maintainAspectRatio: false,
      responsive: true
    }
    var studentData = {
        labels: [
          'Total Students',
          'Male',
          'Female',
        ],
        datasets: [
          {
            data ,
            backgroundColor: ['#f56954', '#00a65a']
          }
        ]
      }
    var studentChart = new Chart(studentchartCanvas, { 
      type: 'bar',
      data: studentData,
      options: Options
    })
  }
  function loadCourseCoverageCanvas(data = [12,7]){
    var Options = {
        legend: {
          display: false
        },
        maintainAspectRatio: false,
        responsive: true
      }
    var courseCoverageCanvase = $('#course-coverage-chart-canvas').get(0).getContext('2d')
    var studentData = {
        labels: [
          'Total Chapters',
          'Chapter Covered'
        ],
        datasets: [
          {
            data,
            backgroundColor: ['#f56954', '#00a65a']
          }
        ]
      }
    var coverageChart = new Chart(courseCoverageCanvase, { 
      type: 'bar',
      data: studentData,
      options: Options
    })
  }
  function loadAttendanceCanvas(data = [11, 19]){
    var pieChartCanvas = $('#sales-chart-canvas').get(0).getContext('2d')
   
    var pieData = {
      labels: [
        'Total Present',
        'Total Absent',
        'Total Late',
      ],
      datasets: [
        {
          data,
          backgroundColor: ['#00a65a', '#f56954' , '#000']
        }
      ]
    }
    var pieOptions = {
      legend: {
        display: true
      },
      maintainAspectRatio: false,
      responsive: true
    }
    var pieChart = new Chart(pieChartCanvas, { // lgtm[js/unused-local-variable]
      type: 'doughnut',
      data: pieData,
      options: pieOptions
    })
  }

  
function setdeleteModalId(id) {
    if (typeof id === 'number') {
      const btnRemove = document.getElementById('removeRecord');
      btnRemove.setAttribute('dataid', id)
    } else {
      showToast('Invalid Id', 'The Delete Record id is Invalid', 'warning');
      return;
    }
  }
  function deleteRecord(e) {
    const id = Number(e.getAttribute('dataid'));
    if (typeof id === 'number') {
      let feildId = Number(id);
      $.ajax({
        url: window.location.pathname + `/${feildId}`,
        method: 'DELETE',
        success: function (response) {
  
          console.log(response)
          if (response.deleted) {
            showToast('Delted', 'Record Deleted', 'success')
            setTimeout(() => window.location.reload(), 1000)
          } else {
            showToast('Failed To Delete', response.message, 'error')
          }
  
        },
        error: function (xhr, status, error) {
          showToast(status, 'AJAX request error:', 'error');
        }
      });
    } else {
  
      showToast('Invalid Id', 'The Delete Record id is Invalid', 'warning');
      return;
    }
  }
  function showLoader(show = true) {
    var $preloader = document.querySelector('.preloader');
    $preloader.style.background = show ? 'transparent' : '#fff'
    $preloader.style.height =  show ? '100vh' : 0
    $preloader.children[0].style.display =  show ? 'block' : 'none'
  }
  function showToast(title, message, type = 'success' | 'warning' | 'info' | 'error') {
    $.toast({
        text: message, // Text that is to be shown in the toast
        heading: title, // Optional heading to be shown on the toast
        icon: type, // Type of toast icon
        showHideTransition: 'slide', // fade, slide or plain
        allowToastClose: true, // Boolean value true or false
        hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
        stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
        position: 'top-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
  
  
  
        textAlign: 'left', // Text alignment i.e. left, right or center
        loader: true, // Whether to show loader or not. True by default
        loaderBg: '#9EC600', // Background color of the toast loader
        beforeShow: function() {}, // will be triggered before the toast is shown
        afterShown: function() {}, // will be triggered after the toat has been shown
        beforeHide: function() {}, // will be triggered before the toast gets hidden
        afterHidden: function() {} // will be triggered after the toast has been hidden
    });
  }


  console.log('`schooladmin` component mounted');


