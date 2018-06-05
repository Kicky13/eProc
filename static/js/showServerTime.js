var base_url = $('#base-url').val();
// var setIntervalServer = setInterval(function(){
// $.ajax({
//         url: base_url+'Auction/getCurrentTime',
//         type: 'POST',
//         dataType: 'json',
//         beforeSend: function() {
//             $('#loading').hide();
//             $('#freeze').hide();
//         },
//     }).done(function(data) {
//         jQuery(".real_jam").html(data);
//         //console.log("date:"+data);
//     });
// },5000);

// if(typeof(EventSource)!=="undefined") {
//     var source=new EventSource(base_url+'waktu.php'); //server.php is the name of the server page
//     source.onmessage=function(event)
//      {
//      document.getElementById("tes_jam").innerHTML=event.data;
//      console.log(event.data);
//      };
// }
// else {
//     document.getElementById("serverData").innerHTML="Whoops! Your browser doesn't receive server-sent events.";
// }
 
var serverClock = jQuery(".real_jam");
if (serverClock.length > 0) {
 
    showServerTime(serverClock, serverClock.text());
 
}
 
function showServerTime(obj, time) {
        time = time.split(" ");
    var parts   = time[3].split(":"),
        newTime = new Date();
        
    
    newTime.setHours(parseInt(parts[0], 10));
    newTime.setMinutes(parseInt(parts[1], 10));
    newTime.setSeconds(parseInt(parts[2], 10));

    var timeDifference  = new Date().getTime() - newTime.getTime();
    var methods = {
 
        displayTime: function () {
 
            var now = new Date(new Date().getTime() - timeDifference);
            var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            var tgl =[
                methods.leadZeros(now.getUTCDate(), 2),
                months[now.getMonth()],
                now.getFullYear()
                ].join(" ");
            var jam =[                
                methods.leadZeros(now.getHours(), 2),
                methods.leadZeros(now.getMinutes(), 2),
                methods.leadZeros(now.getSeconds(), 2) 
                ].join(":");
            obj.text(tgl+' '+jam);
 
            setTimeout(methods.displayTime, 500);
 
        },
 
        leadZeros: function (time, width) {
 
            while (String(time).length < width) {
                time = "0" + time;
            }
            return time;
 
        }
    }
    methods.displayTime();
}