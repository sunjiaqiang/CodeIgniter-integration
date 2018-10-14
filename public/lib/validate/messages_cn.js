/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: CN
 */
jQuery.extend(jQuery.validator.messages, {
    required: "必填",
    remote: "请修正该字段",
    email: "请输入正确格式的电子邮件",
    url: "请输入合法的网址",
    date: "请输入合法的日期",
    dateISO: "请输入合法的日期 (ISO).",
    number: "请输入合法的数字",
    bankcard: "请输入合法的银行账号",
    digits: "只能输入整数",
    creditcard: "请输入合法的信用卡号",
    equalTo: "请再次输入相同的值",
    accept_new: "请输入拥有合法后缀名的字符串",
    maxlength: jQuery.validator.format("请输入一个长度最多是 {0} 的字符串"),
    minlength: jQuery.validator.format("请输入一个长度最少是 {0} 的字符串"),
    rangelength: jQuery.validator.format("请输入一个长度介于 {0} 和 {1} 之间的字符串"),
    range: jQuery.validator.format("请输入一个介于 {0} 和 {1} 之间的值"),
    max: jQuery.validator.format("请输入一个最大为 {0} 的值"),
	sel_min: jQuery.validator.format("请选择"),
    min: jQuery.validator.format("请输入一个最小为 {0} 的值")
});

$.validator.addMethod("username",function(value) {
    var p=/^[0-9a-z_A-Z\u4e00-\u9fa5]+$/;
    return p.exec(value)?true:false;
},"只能由英文字母、数字、中文和下划线组成");
$.validator.addMethod("path",function(value) {
    var p=/^[0-9a-zA-Z_]+$/;
    return (p.exec(value)||value=='')?true:false;
},"只能由英文字母、数字组成");
$.validator.addMethod("isMobile", function(value, element) {
    var length = value.length;
    return this.optional(element) || (length == 11 && /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(value));
}, "请正确填写您的手机号码");

$.validator.addMethod("isNotMobile", function(value, element) {
    var length = value.length;
    return !(this.optional(element) || (length == 11 && /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(value)));
}, "不能使用手机号码");

$.validator.addMethod("isNotEmail", function(value, element) {
    return !(this.optional(element) || /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(value));
}, "不能使用邮箱地址");

$.validator.addMethod("isPhone", function(value, element) {
    var tel = /^(\d{3,4}-?)?\d{7,9}$/g;
    return this.optional(element) || (tel.test(value));
}, "请正确填写您的电话号码");
$.validator.addMethod("isZipCode", function(value, element) {
    var tel = /^[0-9]{6}$/;
    return this.optional(element) || (tel.test(value));
}, "请正确填写您的邮政编码");

$.validator.addMethod("selected",function(value) {
    return (value==''||value==0)?false:true;
}, "请选择");
$.validator.addMethod("selected_companyinfo",function(value) {
    return (value==''||value<=0)?false:true;
}, "请选择");

$.validator.addMethod("isCheck", function(value, element) {
    var reg =  /^[^\'?,`~():;!@#$%^&*<>+=\\\][\]\{\}]*$/ ;
    return this.optional(element) || (reg.test(value));
}, "请正确填写参数");

$.validator.addMethod("isCheck2", function(value, element) {
    var reg =  /^[^\',`~:;!@#$%^&*<>+=\\\][\]\{\}]*$/ ;
    return this.optional(element) || (reg.test(value));
}, "请正确填写参数");

$.validator.addMethod("isDate", function(value, element){
	var ereg = /^(\d{1,4})(-|\/)(\d{1,2})(-|\/)(\d{1,2})$/;
	var r = value.match(ereg);
	if (r == null) {
		return false;
	}
	var d = new Date(r[1], r[3] - 1, r[5]);
	var result = (d.getFullYear() == r[1] && (d.getMonth() + 1) == r[3] && d.getDate() == r[5]);
	return this.optional(element) || (result);
}, "请输入正确的日期");
 
// 汉字
jQuery.validator.addMethod("chcharacter", function(value, element) {
    var tel = /^[\u4e00-\u9fa5]+$/;
    return this.optional(element) || (tel.test(value));
}, "请输入汉字");

// 身份证号码验证   
jQuery.validator.addMethod("idcardno", function(value, element) {
    return this.optional(element) || isIdCardNo(value);   
}, "请正确输入身份证号码");

//时间格式验证
jQuery.validator.addMethod("istime", function(value, element) {
    //非必填 有值时验证
    //格式为 18:00
    if (value != "") {
        if (value.indexOf(":") == -1) {
            return false;
        }
        else {
            var arr = value.split(":");
            if(arr[0] > 23 || arr[0] < 0) {
                return false;
            }
            if(arr[1] > 59 || arr[1] < 0) {
                return false;
            }
        }
    }
    return true;
}, "格式如18:00");

/**
 * 身份证号码验证
 *
 */
function isIdCardNo(num) {

 var factorArr = new Array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2,1);
 var parityBit=new Array("1","0","X","9","8","7","6","5","4","3","2");
 var varArray = new Array();
 var intValue;
 var lngProduct = 0;
 var intCheckDigit;
 var intStrLen = num.length;
 var idNumber = num;
   // initialize
     if ((intStrLen != 15) && (intStrLen != 18)) {
         return false;
     }
     // check and set value
     for(i=0;i<intStrLen;i++) {
         varArray[i] = idNumber.charAt(i);
         if ((varArray[i] < '0' || varArray[i] > '9') && (i != 17)) {
             return false;
         } else if (i < 17) {
             varArray[i] = varArray[i] * factorArr[i];
         }
     }
     
     if (intStrLen == 18) {
         //check date
         var date8 = idNumber.substring(6,14);
         if (isDate8(date8) == false) {
            return false;
         }
         // calculate the sum of the products
         for(i=0;i<17;i++) {
             lngProduct = lngProduct + varArray[i];
         }
         // calculate the check digit
         intCheckDigit = parityBit[lngProduct % 11];
         // check last digit
         if (varArray[17] != intCheckDigit) {
             return false;
         }
     }
     else{//length is 15
         //check date
         var date6 = idNumber.substring(6,12);
         if (isDate6(date6) == false) {

             return false;
         }
     }
     return true;
     
 }
/**
 * 判断是否为“YYYYMM”式的时期
 *
 */
function isDate6(sDate) {
   if(!/^[0-9]{6}$/.test(sDate)) {
      return false;
   }
   var year, month, day;
   year = sDate.substring(0, 4);
   month = sDate.substring(4, 6);
   if (year < 1700 || year > 2500) return false
   if (month < 1 || month > 12) return false
   return true
}
/**
 * 判断是否为“YYYYMMDD”式的时期
 *
 */
function isDate8(sDate) {
   if(!/^[0-9]{8}$/.test(sDate)) {
      return false;
   }
   var year, month, day;
   year = sDate.substring(0, 4);
   month = sDate.substring(4, 6);
   day = sDate.substring(6, 8);
   var iaMonthDays = [31,28,31,30,31,30,31,31,30,31,30,31]
   if (year < 1700 || year > 2500) return false
   if (((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0)) iaMonthDays[1]=29;
   if (month < 1 || month > 12) return false
   if (day < 1 || day > iaMonthDays[month - 1]) return false
   return true
} 
 
//validate与metadata以及jquery.form结合使用
$(function() {
    $.metadata.setType("attr","validate");
    $(".formvalidate").validate({
        errorElement: "span",
        errorClass: "errormsg",
        success:"valid",
		submitHandler: function(form) 
		{
            $('form').find('.btn_submit').attr("disabled", true).removeClass('btn_submit ').addClass('btn_disabled');

            $(form).ajaxSubmit({
			    dataType: 'json',
				type:'post',
				success: function (data) {
		            if(data.status==true){
		            	ajax_close(data);
		            }else{
		            	ajax_close(data);
		            }
		            if(data.url&&data.url!=undefined){
		                setTimeout(function(){
		                	window.location.href=data.url;
		                },3000);
		            }
		            if(data.status==true&&data.url==undefined){
		                setTimeout(function(){
		                	window.location.href=data.url;		                    
		                },3000);
		            }
				},
				error: function(XmlHttpRequest, textStatus, errorThrown){  
					ajax_close();
                } 
			});

		}  
    });   
});

/**
 * ajax提示时执行信息
 */
function ajax_close(data){
	var timer;
	var $icon = 'error';
	if(data.status=='1')$icon = 'succeed';
    if(data.url.length==0){
        $('form').find('.J_ajax_submit_btn').removeClass('btn_disabled').addClass('btn_submit').removeAttr('disabled');
        $('form').find('.btn_submit').removeClass('btn_disabled').addClass('btn_submit').removeAttr('disabled');
    }
	$.dialog({
	    content: data.info,
	    icon:$icon,
        lock:true,
        opacity:.1,
	    init: function () {
	    	var that = this, i = (typeof gi!='undefined') ? gi:3;
	        var fn = function () {
	            that.title(i + '秒后关闭');
	            !i && that.close();
	            i --;
	        };
	        timer = setInterval(fn, 1000);
	        fn();
	    },
	    close: function () {
	    	clearInterval(timer);
	    }
	}).show();
}