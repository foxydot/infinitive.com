jQuery(document).ready(function(e){e("ul li:first-child").addClass("first-child");e("ul li:last-child").addClass("last-child");e("ul li:nth-child(even)").addClass("even");e("ul li:nth-child(odd)").addClass("odd");e("table tr:first-child").addClass("first-child");e("table tr:last-child").addClass("last-child");e("table tr:nth-child(even)").addClass("even");e("table tr:nth-child(odd)").addClass("odd");e("tr td:first-child").addClass("first-child");e("tr td:last-child").addClass("last-child");e("tr td:nth-child(even)").addClass("even");e("tr td:nth-child(odd)").addClass("odd");e("div:first-child").addClass("first-child");e("div:last-child").addClass("last-child");e("div:nth-child(even)").addClass("even");e("div:nth-child(odd)").addClass("odd");e("#footer-widgets div.widget:first-child").addClass("first-child");e("#footer-widgets div.widget:last-child").addClass("last-child");e("#footer-widgets div.widget:nth-child(even)").addClass("even");e("#footer-widgets div.widget:nth-child(odd)").addClass("odd");var t=e("#footer-widgets div.widget").length;e("#footer-widgets").addClass("cols-"+t);e(".ftr-menu ul.menu>li").after(function(){if(!e(this).hasClass("last-child")&&e(this).hasClass("menu-item")&&e(this).css("display")!="none")return'<li class="separator">|</li>'});e(".site-inner").addClass("container");e(".content-sidebar .content-sidebar-wrap").addClass("row");e(".content-sidebar .content").addClass("col-md-8 col-sm-12");e(".content-sidebar .sidebar").addClass("col-md-4");e('.menu li[class*="icon-"] a').prepend("<i></i>")});