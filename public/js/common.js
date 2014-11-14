
/**
 * Created with sublime text 2.
 * Author: yakun.xu
 * Date: 14-11-12
 */

function U() {
    var url = arguments[0] || [];
    var param = arguments[1] || {};
    var url_arr = url.split('/');

    if (!$.isArray(url_arr) || url_arr.length < 2 || url_arr.length > 3) {
        return '';
    }

    if (url_arr.length == 2)
        url_arr.unshift(_GROUP_);

    var pre_arr = ['g', 'm', 'a'];

    var arr = [];
    for (d in pre_arr)
        arr.push(pre_arr[d] + '=' + url_arr[d]);

    for (d in param)
        arr.push(d + '=' + param[d]);

    return _APP_+'?'+arr.join('&');
}

function ModalHide(id) {
    $( '#' + id ).modal('hide');
}

function ModalShow(id) {
    $( '#' + id ).modal();
}

function all_select(name) {
    $('input[name="'+name+'"]').each(function(i, n) {
        n = $(n);
        if(!n.attr('checked')) {
            n.click();
        }
    });
}

Array.prototype.indexOf || (Array.prototype.indexOf = function(item,i){
    // for ie
    i || (i = 0);
    var length = this.length;
    if(i < 0){
        i = length + i;
    }
    for(; i < length; i++){
        if(this[i] === item) return i;
    }
    return -1;
});

Array.prototype.map || (Array.prototype.map = function(fn,scope) {
    var result = [],ri = 0;
    for (var i = 0,n = this.length; i < n; i++){
        if(i in this){
            result[ri++]  = fn.call(scope ,this[i],i,this);
        }
    }
    return result;
});

Array.prototype.has || (Array.prototype.has = function(val) {
    var i;
    for(i = 0; i < this.length; i++) {
        if(this[i] == val) {
            return true;
        }
    }
    return false;
});


Array.prototype.remove || (Array.prototype.remove = function(val) {
    var i, j;
    for(i = 0; i < this.length; i++) {
        if(this[i] == val) {
            for(j = i; j < this.length - 1; j++) {
                this[j] = this[j + 1];
            }
            this.length = this.length - 1;
        }
    }
});


Array.prototype.unique || (Array.prototype.unique = function() {
    var temp = {}, len = this.length;
    for(var i=0; i < len; i++) {
        var tmp = this[i];
        if(!temp.hasOwnProperty(tmp)) {
            temp[this[i]] = "not hasOwnProperty";
        }
    }
    this.length = 0;
    len = 0;
    for(var i in temp) {
        this[len++] = i;
    }
    return this;
});

Array.prototype.in_array = function(e) {
    for(i = 0; i < this.length; i++) {
        if(this[i] == e) {
            return true;
        }
    }
    return false;
}