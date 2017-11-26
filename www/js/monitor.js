var Move = function (x, y) {
    this.x = x;
    this.y = y;
};
var MoveCollection = function(){
    var sid;
    this.sessionId = (sid = document.cookie.match(/PHPSESSID=([^;]+)/)) ? sid[1] : sid;
    this.clientIp = myIp;
    this.collection = [];
};
MoveCollection.prototype.add = function (m) {
    this.collection.push(m);
};
MoveCollection.prototype.toString = function () {
    return JSON.stringify(this);
};

MoveCollection.prototype.updateData = function () {
    var xhttp = new XMLHttpRequest();
    var updateChain = {
        ajaxTrigger : function(trigger){
            trigger = typeof trigger == "undefined" ? this.sessionGetter : trigger;
            xhttp.onreadystatechange = trigger.callback;
            xhttp.open(trigger.method, trigger.url, true);
            xhttp.setRequestHeader('X-REQUESTED-WITH', 'XMLHttpRequest');
            xhttp.send(trigger.data);
        },
        sessionGetter : {
            url: "/tracking/sessionid", method: "GET", callback: function () {
                if (this.readyState !== 4 || this.status !== 200){
                    return;
                }
                mc.sessionId = JSON.parse(this.response).id;
                updateChain.ajaxTrigger(updateChain.trackingUpdater);
            }
        },
        trackingUpdater : {
            url: "/tracking", method: "POST", callback: function () {
                if (this.readyState !== 4 || this.status !== 200){
                    return;
                }
                console.log(this.response);
            }, data: this
        }
    }, chainItem;

    updateChain.ajaxTrigger();

    // for(var i=0; i<updateChain.length; i++){
    //     chainItem = updateChain[i];
    //     xhttp.onreadystatechange = chainItem.callback;
    //     xhttp.open(chainItem.method, chainItem.url, true);
    //     xhttp.send(chainItem.data);
    //     break;
    // }
    // xhttp.onreadystatechange = function() {
    //     if (this.readyState == 4 && this.status == 200) {
    //         document.getElementById("demo").innerHTML = this.response;
    //     }
    // };
    // xhttp.open("POST", "/tracking", true);
    // xhttp.send(this);
};

var mc = new MoveCollection();
document.onreadystatechange = function () {
    var docMousemoveCallback = function(e){
        mc.add(new Move(e.pageX, e.pageY));
    };
    if (document.readyState == "complete") {
        document.onmousemove = docMousemoveCallback;
    }
};