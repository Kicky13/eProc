var nVer = navigator.appVersion;
var nAgt = navigator.userAgent;
var browserName  = navigator.appName;
var fullVersion  = ''+parseFloat(navigator.appVersion); 
var majorVersion = parseInt(navigator.appVersion,10);
var nameOffset,verOffset,ix;

console.log(''
 +'Browser name  = '+browserName+'\n'
 +'Full version  = '+fullVersion+'\n'
 +'Major version = '+majorVersion+'\n'
 +'navigator.appName = '+navigator.appName+'\n'
 +'navigator.userAgent = '+navigator.userAgent+'\n'
)

// console.log($.browser.webkit/opera/msie/mozilla);