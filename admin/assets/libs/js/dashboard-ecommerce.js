var sadCount = 0,
    neutralCount = 0,
    happyCount = 0,
    count = 0;
 
var u = window.location.href;
var ar = u.split('/');
var server = ar[0]+"//"+window.location.hostname+"/hpysrvy.com";

var userId = document.getElementById("session").value;
function getDataBarChart(count, storeId){       
    
    var dataToSend = {"userId": userId, 'storeId': storeId };  
    $.ajax({
        url: server+"/surveyresult.php",
        type: 'GET',
        data: dataToSend,
        contentType: 'application/json; charset=utf-8',
        success: function(response){
            var result = response.data;
                count = count;
            var categoryArray = result.category;

                if(categoryArray.length == 0){
                    $('.ct-chart-product.ct-golden-section').html('There are no categories. Click on "Categories" Tab to create custom categories.');
                }
                else{
                    
                    var categoryName = [];
                    var categorySadCount = [];
                    var categoryNeautralCount = [];
                    var categoryHappyCount = [];
                    var categoryTotalCount = [];

                    for(var i=0; i<result.category.length; i+=1){
                        categoryName.push(result.category[i].name);

                        if(count == 0){
                            categorySadCount.push(result.category[i].sadCount);
                            getSurveyCategoryResult(categoryName,categorySadCount);
                        }
                        if(count == 1){
                            categoryNeautralCount.push(result.category[i].neutralCount); 
                            getSurveyCategoryResult1(categoryName,categoryNeautralCount);  
                        }
                        if(count == 2){
                            categoryHappyCount.push(result.category[i].happyCount);
                            getSurveyCategoryResult2(categoryName,categoryHappyCount);
                        }
                    }
                    $('.ct-chart-product.ct-golden-section').html("");                
                }
            
            },
            error: function(){
                console.log("error");
            }
        }); 
}

function getSurveyCategoryResult(categoryName,categorySadCount){
    //  $(".emoji-sad").css({           
    //     "outline": "2px solid",
    //     "outline-color": "red"
    // }); 
    //  $(".emoji-neautral").css({           
    //     "outline": "",
    //     "outline-color": ""
    // }); 
    //  $(".emoji-happy").css({           
    //     "outline": "",
    //     "outline-color": ""
    // }); 
    $(".emoji-sad").css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});
    // $(".emoji-sad").css({'border':'red solid 1.5px','padding': '2.5px 2.5px 3px', 'border-radius':'40px', 'height':'55px', 'width': '55px'});    
    $(".emoji-neautral").css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});
    $(".emoji-happy").css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});

   $(function() {
        "use strict";
        // ============================================================== 
        // Product Sales
        // ============================================================== 

        new Chartist.Bar('.ct-chart-product', {
            labels: categoryName,
            series: [                  
            categorySadCount,                    
            ]
        }, {
            high: 100,
            low: 0,
            stackBars: true,
            axisY: {
                labelInterpolationFnc: function(value) {
                    return value + '%';
                }
            }
        }).on('draw', function(data) {
            if (data.type === 'bar') {
                data.element.attr({                       
                    style: 'stroke-width: 25px;stroke: #E1140B;'                        
                });
            }
        });
    });
}

function getSurveyCategoryResult1(categoryName,categoryNeautralCount){ 
    // $(".emoji-neautral").css({              
    //     "outline": "2px solid",
    //     "outline-color": "rgb(255, 151, 3)"
    // });
    // $(".emoji-sad").css({           
    //     "outline": "",
    //     "outline-color": ""
    // }); 
    // $(".emoji-happy").css({           
    //     "outline": "",
    //     "outline-color": ""
    // }); 

    $(".emoji-neautral").css({'border':'rgb(255, 151, 3) solid 1.5px','padding': '2.5px 2.5px 3px', 'border-radius':'40px', 'height':'55px', 'width': '55px'});
    $(".emoji-sad").css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});
    $('.emoji-happy').css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});


    $(function() {
        "use strict";
        // ============================================================== 
        // Product Sales
        // ============================================================== 
        var chart = new Chartist.Bar('.ct-chart-product', {
            labels: categoryName,
            series: [                  
            categoryNeautralCount,                    
            ]
        }, {
            high: 100,
            low: 0,
            stackBars: true,
            axisY: {
                labelInterpolationFnc: function(value) {
                    return value + '%';
                }
            }
        }).on('draw', function(data) {
            if (data.type === 'bar') {
                data.element.attr({                       
                    style: 'stroke-width: 25px;stroke: rgb(255, 151, 3)'                        
                });
            }
        });
    });
}

function getSurveyCategoryResult2(categoryName,categoryHappyCount){ 
    // $(".emoji-happy").css({             
    //     "outline": "2px solid",
    //     "outline-color": "#66CC00"
    // });
    // $(".emoji-neautral").css({           
    //     "outline": "",
    //     "outline-color": ""
    // }); 
    // $(".emoji-sad").css({           
    //     "outline": "",
    //     "outline-color": ""
    // }); 

    $(".emoji-happy").css({'border':'rgb(134, 209, 2) solid 1.5px','padding': '2.5px 2.5px 3px', 'border-radius':'40px', 'height':'55px', 'width': '55px'});
    $(".emoji-sad").css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});
    $(".emoji-neautral").css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});

    $(function() {
        "use strict";
        // ============================================================== 
        // Product Sales
        // ============================================================== 

        new Chartist.Bar('.ct-chart-product', {
            labels: categoryName,
            series: [                  
            categoryHappyCount,                    
            ]
        }, {
            high: 100,
            low: 0,
            stackBars: true,
            axisY: {
                labelInterpolationFnc: function(value) {
                    return value + '%';
                }
            }
        }).on('draw', function(data) {
            if (data.type === 'bar') {
                data.element.attr({                       
                    style: 'stroke-width: 25px;stroke: #66CC00'                        
                });
            }
        });
    });
}

// ============================================================== 
// Product Category
// ============================================================== 
var chart = new Chartist.Pie('.ct-chart-category', {
    series: [60, 30, 30],
    labels: ['Bananas', 'Apples', 'Grapes']
}, {
    donut: true,
    showLabel: false,
    donutWidth: 40

});


chart.on('draw', function(data) {
    if (data.type === 'slice') {
        // Get the total path length in order to use for dash array animation
        var pathLength = data.element._node.getTotalLength();

        // Set a dasharray that matches the path length as prerequisite to animate dashoffset
        data.element.attr({
            'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
        });

        // Create animation definition while also assigning an ID to the animation for later sync usage
        var animationDefinition = {
            'stroke-dashoffset': {
                id: 'anim' + data.index,
                dur: 1000,
                from: -pathLength + 'px',
                to: '0px',
                easing: Chartist.Svg.Easing.easeOutQuint,
                // We need to use `fill: 'freeze'` otherwise our animation will fall back to initial (not visible)
                fill: 'freeze'
            }
        };

        // If this was not the first slice, we need to time the animation so that it uses the end sync event of the previous animation
        if (data.index !== 0) {
            animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
        }

        // We need to set an initial value before the animation starts as we are not in guided mode which would do that for us
        data.element.attr({
            'stroke-dashoffset': -pathLength + 'px'
        });

        // We can't use guided mode as the animations need to rely on setting begin manually
        // See http://gionkunz.github.io/chartist-js/api-documentation.html#chartistsvg-function-animate
        data.element.animate(animationDefinition, false);
    }
});

// For the sake of the example we update the chart every time it's created with a delay of 8 seconds



// ============================================================== 
// Customer acquisition
// ============================================================== 
var chart = new Chartist.Line('.ct-chart', {
    labels: ['Mon', 'Tue', 'Wed'],
    series: [
    [1, 5, 2, 5],
    [2, 3, 4, 8]

    ]
}, {
    low: 0,
    showArea: true,
    showPoint: false,
    fullWidth: true
});

chart.on('draw', function(data) {
    if (data.type === 'line' || data.type === 'area') {
        data.element.animate({
            d: {
                begin: 2000 * data.index,
                dur: 2000,
                from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                to: data.path.clone().stringify(),
                easing: Chartist.Svg.Easing.easeOutQuint
            }
        });
    }
});




// ============================================================== 
// Revenue Cards
// ============================================================== 
// $("#sparkline-revenue").sparkline([5, 5, 7, 7, 9, 5, 3, 5, 2, 4, 6, 7], {
//     type: 'line',
//     width: '99.5%',
//     height: '100',
//     lineColor: '#5969ff',
//     fillColor: '#dbdeff',
//     lineWidth: 2,
//     spotColor: undefined,
//     minSpotColor: undefined,
//     maxSpotColor: undefined,
//     highlightSpotColor: undefined,
//     highlightLineColor: undefined,
//     resize: true
// });



// $("#sparkline-revenue2").sparkline([3, 7, 6, 4, 5, 4, 3, 5, 5, 2, 3, 1], {
//     type: 'line',
//     width: '99.5%',
//     height: '100',
//     lineColor: '#ff407b',
//     fillColor: '#ffdbe6',
//     lineWidth: 2,
//     spotColor: undefined,
//     minSpotColor: undefined,
//     maxSpotColor: undefined,
//     highlightSpotColor: undefined,
//     highlightLineColor: undefined,
//     resize: true
// });



// $("#sparkline-revenue3").sparkline([5, 3, 4, 6, 5, 7, 9, 4, 3, 5, 6, 1], {
//     type: 'line',
//     width: '99.5%',
//     height: '100',
//     lineColor: '#25d5f2',
//     fillColor: '#dffaff',
//     lineWidth: 2,
//     spotColor: undefined,
//     minSpotColor: undefined,
//     maxSpotColor: undefined,
//     highlightSpotColor: undefined,
//     highlightLineColor: undefined,
//     resize: true
// });



// $("#sparkline-revenue4").sparkline([6, 5, 3, 4, 2, 5, 3, 8, 6, 4, 5, 1], {
//     type: 'line',
//     width: '99.5%',
//     height: '100',
//     lineColor: '#fec957',
//     fillColor: '#fff2d5',
//     lineWidth: 2,
//     spotColor: undefined,
//     minSpotColor: undefined,
//     maxSpotColor: undefined,
//     highlightSpotColor: undefined,
//     highlightLineColor: undefined,
//     resize: true,
// });





// ============================================================== 
// Total Revenue
// ============================================================== 
// Morris.Area({
//     element: 'morris_totalrevenue',
//     behaveLikeLine: true,
//     data: [
//     { x: '2016 Q1', y: 0, },
//     { x: '2016 Q2', y: 7500, },
//     { x: '2017 Q3', y: 15000, },
//     { x: '2017 Q4', y: 22500, },
//     { x: '2018 Q5', y: 30000, },
//     { x: '2018 Q6', y: 40000, }
//     ],
//     xkey: 'x',
//     ykeys: ['y'],
//     labels: ['Y'],
//     lineColors: ['#5969ff'],
//     resize: true

// });

// ============================================================== 
// Revenue By Categories
// ============================================================== 
var sadCount = 0,
    neutralCount = 0,
    happyCount = 0;

function selectStoreId(){
    var storeId = $("#storeIdForPieChart").val(); 
    getData(storeId);  
    getDataBarChart(count, storeId);
}

function getData(storeId){
    var userId = sessionStorage.getItem("id");    
    var dataToSend = {"userId": userId, "storeId": storeId};   
    $.ajax({
        url: server+"/surveyresult.php",
        type: 'GET',
        data: dataToSend,
        contentType: 'application/json; charset=utf-8',
        success: function(response){
            var result = response.data;            
            var totalCount = result.totalCount;
            
            happyCount = result.totalHappyCount;
            happyCount = parseInt(happyCount*100/totalCount);          

            neutralCount = result.totalNeutralCount;
            neutralCount = parseInt(neutralCount*100/totalCount);            

            sadCount = result.totalSadCount;
            sadCount = parseInt(sadCount*100/totalCount);  
                   
            var abc = "http://"+window.location.hostname+"/hpysrvy.com/admin/review.php?u="+userId+'&s='+storeId;
            (totalCount == 0 ) ? document.getElementById('c3chart_category').innerHTML = 'No data yet.<a href="' + abc + '" target="_blank"> Click here</a> to create your first custom survey' : getCountOfSurvey(happyCount, neutralCount, sadCount);
            // (totalCount == 0 ) ? ($("#c3chart_category").html("No data yet. Click here to create your first custom survey")) : getCountOfSurvey(happyCount, neutralCount, sadCount);     
                            
        },
        error: function(){
            console.log("error");
        }
    }); 
}

function getCountOfSurvey(happyCount, neutralCount, sadCount){    
    var chart = c3.generate({   
        bindto: "#c3chart_category",
        data: {
            columns: [
            ['Happy', happyCount],
            ['Neutral', neutralCount],
            ['Sad', sadCount],                        
            ],
            type: 'donut',

            onclick: function(d, i) { console.log("onclick", d, i); },
            onmouseover: function(d, i) { console.log("onmouseover", d, i); },
            onmouseout: function(d, i) { console.log("onmouseout", d, i); },

            colors: {   
                Happy: '#66CC00',
                Neutral: 'rgb(255, 151, 3)',
                Sad: '#E1140B',                        
            }
        },
        donut: {
            label: {
                show: true
            }
        },

    });
}
